<?php

namespace EG\Language\Http\Controllers;

use Assets2;
use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\DeletedContentEvent;
use EG\Base\Events\UpdatedContentEvent;
use EG\Base\Http\Controllers\BaseController;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Base\Supports\Language;
use EG\Language\Http\Requests\LanguageRequest;
use EG\Language\LanguageManager;
use EG\Language\Models\LanguageMeta;
use EG\Language\Repositories\Interfaces\LanguageInterface;
use EG\Language\Repositories\Interfaces\LanguageMetaInterface;
use EG\Setting\Supports\SettingStore;
use DB;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class LanguageController extends BaseController
{
    /**
     * @var LanguageInterface
     */
    protected $languageRepository;

    /**
     * @var LanguageMetaInterface
     */
    protected $languageMetaRepository;

    /**
     * LanguageController constructor.
     * @param LanguageInterface $languageRepository
     * @param LanguageMetaInterface $languageMetaRepository
     */
    public function __construct(LanguageInterface $languageRepository, LanguageMetaInterface $languageMetaRepository)
    {
        $this->languageRepository = $languageRepository;
        $this->languageMetaRepository = $languageMetaRepository;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        page_title()->setTitle(trans('plugins/language::language.name'));

        Assets2::addScriptsDirectly(['vendor/core/plugins/language/js/language.js']);

        $languages = Language::getListLanguages();
        $flags = Language::getListLanguageFlags();
        $activeLanguages = $this->languageRepository->all();

        return view('plugins/language::index', compact('languages', 'flags', 'activeLanguages'));
    }

    /**
     * @param LanguageRequest $request
     * @param BaseHttpResponse $response
     * @param LanguageManager $languageManager
     * @return BaseHttpResponse
     * @throws Throwable
     */
    public function postStore(LanguageRequest $request, BaseHttpResponse $response, LanguageManager $languageManager)
    {
        try {
            $language = $this->languageRepository->getFirstBy([
                'lang_code' => $request->input('lang_code'),
            ]);

            if ($language) {
                return $response
                    ->setError()
                    ->setMessage(__('This language was added already!'));
            }

            if ($this->languageRepository->count() == 0) {
                $request->merge(['lang_is_default' => 1]);
            }

            $language = $this->languageRepository->createOrUpdate($request->except('lang_id'));

            event(new CreatedContentEvent(LANGUAGE_MODULE_SCREEN_NAME, $request, $language));

            try {
                $models = $languageManager->supportedModels();

                if ($this->languageRepository->count() == 1) {
                    foreach ($models as $model) {

                        if (!class_exists($model)) {
                            continue;
                        }

                        $ids = LanguageMeta::where('reference_type', $model)
                            ->pluck('reference_id')
                            ->all();

                        $table = (new $model)->getTable();

                        $referenceIds = DB::table($table)
                            ->whereNotIn('id', $ids)
                            ->pluck('id')
                            ->all();

                        $data = [];
                        foreach ($referenceIds as $referenceId) {
                            $data[] = [
                                'reference_id'     => $referenceId,
                                'reference_type'   => $model,
                                'lang_meta_code'   => $language->lang_code,
                                'lang_meta_origin' => md5($referenceId . $model . time()),
                            ];
                        }

                        LanguageMeta::insert($data);
                    }
                }
            } catch (Exception $exception) {
                return $response
                    ->setData(view('plugins/language::partials.language-item', ['item' => $language])->render())
                    ->setMessage($exception->getMessage());
            }

            return $response
                ->setData(view('plugins/language::partials.language-item', ['item' => $language])->render())
                ->setMessage(trans('core/base::notices.create_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Throwable
     */
    public function update(Request $request, BaseHttpResponse $response)
    {
        try {
            $language = $this->languageRepository->getFirstBy(['lang_id' => $request->input('lang_id')]);
            if (empty($language)) {
                abort(404);
            }
            $language->fill($request->input());
            $language = $this->languageRepository->createOrUpdate($language);

            event(new UpdatedContentEvent(LANGUAGE_MODULE_SCREEN_NAME, $request, $language));

            return $response
                ->setData(view('plugins/language::partials.language-item', ['item' => $language])->render())
                ->setMessage(trans('core/base::notices.update_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function postChangeItemLanguage(Request $request, BaseHttpResponse $response)
    {
        $referenceId = $request->input('reference_id') ? $request->input('reference_id') : $request->input('lang_meta_created_from');
        $currentLanguage = $this->languageMetaRepository->getFirstBy([
            'reference_id'   => $referenceId,
            'reference_type' => $request->input('reference_type'),
        ]);
        $others = $this->languageMetaRepository->getModel();
        if ($currentLanguage) {
            $others = $others->where('lang_meta_code', '!=', $request->input('lang_meta_current_language'))
                ->where('lang_meta_origin', $currentLanguage->origin);
        }
        $others = $others->select(['reference_id', 'lang_meta_code'])
            ->get();
        $data = [];
        foreach ($others as $other) {
            $language = $this->languageRepository->getFirstBy(['lang_code' => $other->lang_code], [
                'lang_flag',
                'lang_name',
                'lang_code',
            ]);
            if (!empty($language) && !empty($currentLanguage) && $language->lang_code != $currentLanguage->lang_meta_code) {
                $data[$language->lang_code]['lang_flag'] = $language->lang_flag;
                $data[$language->lang_code]['lang_name'] = $language->lang_name;
                $data[$language->lang_code]['reference_id'] = $other->reference_id;
            }
        }

        $languages = $this->languageRepository->all();
        foreach ($languages as $language) {
            if (!array_key_exists($language->lang_code,
                    $data) && $language->lang_code != $request->input('lang_meta_current_language')) {
                $data[$language->lang_code]['lang_flag'] = $language->lang_flag;
                $data[$language->lang_code]['lang_name'] = $language->lang_name;
                $data[$language->lang_code]['reference_id'] = null;
            }
        }

        return $response->setData($data);
    }

    /**
     * @param Request $request
     * @param int $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $language = $this->languageRepository->getFirstBy(['lang_id' => $id]);
            $this->languageRepository->delete($language);
            $deleteDefaultLanguage = false;
            if ($language->lang_is_default) {
                $default = $this->languageRepository->getFirstBy([
                    'lang_is_default' => 0,
                ]);
                if ($default) {
                    $default->lang_is_default = 1;
                    $this->languageRepository->createOrUpdate($default);
                    $deleteDefaultLanguage = $default->lang_id;
                }
            }

            event(new DeletedContentEvent(LANGUAGE_MODULE_SCREEN_NAME, $request, $language));

            return $response
                ->setData($deleteDefaultLanguage)
                ->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function getSetDefault(Request $request, BaseHttpResponse $response)
    {
        $this->languageRepository->update(['lang_is_default' => 1], ['lang_is_default' => 0]);
        $language = $this->languageRepository->getFirstBy(['lang_id' => $request->input('lang_id')]);
        if ($language) {
            $language->lang_is_default = 1;
            $this->languageRepository->createOrUpdate($language);
        }

        event(new UpdatedContentEvent(LANGUAGE_MODULE_SCREEN_NAME, $request, $language));

        return $response->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function getLanguage(Request $request, BaseHttpResponse $response)
    {
        $language = $this->languageRepository->getFirstBy(['lang_id' => $request->input('lang_id')]);

        return $response->setData($language);
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param SettingStore $settingStore
     * @return BaseHttpResponse
     */
    public function postEditSettings(Request $request, BaseHttpResponse $response, SettingStore $settingStore)
    {
        $settingStore
            ->set('language_hide_default', $request->input('language_hide_default', false))
            ->set('language_display', $request->input('language_display'))
            ->set('language_switcher_display', $request->input('language_switcher_display'))
            ->set('language_hide_languages', json_encode($request->input('language_hide_languages', [])))
            ->set('language_show_default_item_if_current_version_not_existed',
                $request->input('language_show_default_item_if_current_version_not_existed'))
            ->save();

        return $response->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param string $code
     * @param LanguageManager $language
     * @return RedirectResponse
     * @since 2.2
     */
    public function getChangeDataLanguage($code, LanguageManager $language)
    {
        $previousUrl = strtok(app('url')->previous(), '?');

        $queryString = null;
        if ($code !== $language->getDefaultLocaleCode()) {
            $queryString = '?' . http_build_query(['ref_lang' => $code]);
        }

        return redirect()->to($previousUrl . $queryString);
    }
}
