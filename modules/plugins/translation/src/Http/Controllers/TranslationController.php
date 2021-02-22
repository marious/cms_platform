<?php
namespace EG\Translation\Http\Controllers;

use EG\Base\Http\Controllers\BaseController;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Base\Supports\Language;
use EG\Translation\Http\Requests\LocaleRequest;
use EG\Translation\Http\Requests\TranslationRequest;
use EG\Translation\Manager;
use EG\Translation\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Assets2;
use Theme;
use File;
use Schema;
use DB;
use Arr;
use App;

class TranslationController extends BaseController
{
    protected $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function getIndex(Request $request)
    {
        page_title()->setTitle(trans('plugins/translation::translation.translations'));

        Assets2::addScripts(['bootstrap-editable'])
            ->addStyles(['bootstrap-editable'])
            ->addScriptsDirectly('vendor/core/plugins/translation/js/translation.js')
            ->addStylesDirectly('vendor/core/plugins/translation/css/translation.css');

        $group = $request->input('group');

        $locales = $this->loadLocales();
        $groups = Translation::groupBy('group');
        $excludeGroups = $this->manager->getConfig('exclude_groups');
        if ($excludeGroups) {
            $groups->whereNotIn('group', $excludeGroups);
        }
        $groups = $groups->select('group')->get()->pluck('group', 'group');
        if ($groups instanceof Collection) {
            $groups = $groups->all();
        }
        $groups = ['' => trans('plugins/translation::translation.choose_a_group')] + $groups;
        $numChanged = Translation::where('group', $group)->where('status', Translation::STATUS_CHANGED)->count();

        $allTranslations = Translation::where('group', $group)->orderBy('key', 'asc')->get();
        $numTranslations = count($allTranslations);
        $translations = [];
        foreach ($allTranslations as $translation) {
            $translations[$translation->key][$translation->locale] = $translation;
        }


        return view('plugins/translation::index')
            ->with('translations', $translations)
            ->with('locales', $locales)
            ->with('groups', $groups)
            ->with('group', $group)
            ->with('numTranslations', $numTranslations)
            ->with('numChanged', $numChanged)
            ->with('editUrl', route('translations.group.edit', ['group' => $group]))
            ->with('deleteEnabled', $this->manager->getConfig('delete_enabled'));


    }

    protected function loadLocales()
    {
        $locales = Translation::groupBy('locale')
                    ->select('locale')
                    ->get()
                    ->pluck('locale');
//        dd($locales);
        if ($locales instanceof Collection) {
            $locales = $locales->all();
        }
        $locales = array_merge([config('app.locale')], $locales);

        return array_unique($locales);
    }


    public function update(TranslationRequest $request,  BaseHttpResponse $response)
    {
        $group = $request->input('group');

        if (!in_array($group, $this->manager->getConfig('exclude_groups'))) {
            $name = $request->input('name');
            $value = $request->input('value');

            [$locale, $key] = explode('|', $name, 2);
            $translation = Translation::firstOrNew([
                'locale' => $locale,
                'group'  => $group,
                'key'    => $key,
            ]);
            $translation->value = (string)$value ?: null;
            $translation->status = Translation::STATUS_CHANGED;
        }

        return $response;
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function postImport(Request $request, BaseHttpResponse $response)
    {
        $counter = $this->manager->importTranslations($request->get('replace', false));

        return $response->setMessage(trans('plugins/translation::translation.import_done', compact('counter')));
    }


    public function postPublish(Request $request, BaseHttpResponse $response)
    {
        $group = $request->input('group');

        $this->manager->exportTranslations($group, $group === '_json');

        return $response->setMessage(trans('plugins/translation::translation.done_publishing'));
    }


    public function getLocales()
    {
        page_title()->setTitle(trans('plugins/translation::translation.locales'));

        Assets2::addScriptsDirectly('vendor/core/plugins/translation/js/locales.js');

        $locales = Language::getAvailableLocales();
        $languages = Language::getListLanguages();
        $flags = Language::getListLanguageFlags();

        return view('plugins/translation::locales', compact('locales', 'languages', 'flags'));
    }

    public function postLocales(LocaleRequest $request, BaseHttpResponse $response)
    {
        $defaultLocale = resource_path('lang/en');
        $locale = $request->input('locale');
        if (File::exists($defaultLocale)) {
            File::copyDirectory($defaultLocale, resource_path('lang/' . $locale));
        }

        $this->createLocaleInPath(resource_path('lang/vendor/core'), $locale);
        $this->createLocaleInPath(resource_path('lang/vendor/packages'), $locale);
        $this->createLocaleInPath(resource_path('lang/vendor/plugins'), $locale);

        $themeLocale = Arr::first(scan_folder(theme_path(Theme::getThemeName() . '/lang')));

        if ($themeLocale) {
            File::copy(theme_path(Theme::getThemeName() . '/lang/' . $themeLocale), resource_path('lang/' . $locale . '.json'));
        }

        return $response->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function deleteLocale($locale, BaseHttpResponse $response)
    {
        if ($locale !== 'en') {
            $defaultLocale = resource_path('lang/' . $locale);
            if (File::exists($defaultLocale)) {
                File::deleteDirectory($defaultLocale);
            }

            if (File::exists(resource_path('lang/' . $locale . '.json'))) {
                File::delete(resource_path('lang/' . $locale . '.json'));
            }

            $this->removeLocaleInPath(resource_path('lang/vendor/core'), $locale);
            $this->removeLocaleInPath(resource_path('lang/vendor/packages'), $locale);
            $this->removeLocaleInPath(resource_path('lang/vendor/plugins'), $locale);

            if (is_plugin_active('translation') && Schema::hasTable('translations')) {
                DB::table('translations')->where('locale', $locale)->delete();
            }
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }

    protected function createLocaleInPath(string $path, $locale)
    {
        $folders = File::directories($path);

        foreach ($folders as $module) {
            foreach (File::directories($module) as $item) {
                if (File::name($item) == 'en') {
                    File::copyDirectory($item, $module . '/' . $locale);
                }
            }
        }

        return count($folders);
    }


    protected function removeLocaleInPath(string $path, $locale)
    {
        $folders = File::directories($path);

        foreach ($folders as $module) {
            foreach (File::directories($module) as $item) {
                if (File::name($item) == $locale) {
                    File::deleteDirectory($item);
                }
            }
        }

        return count($folders);
    }


    public function getThemeTranslations(Request $request)
    {
        page_title()->setTitle(trans('plugins/translation::translation.theme-translations'));

        Assets2::addScriptsDirectly('vendor/core/plugins/translation/js/theme-translations.js')
            ->addStylesDirectly('vendor/core/plugins/translation/css/theme-translations.css');

        $groups = Language::getAvailableLocales();
        $defaultLanguage = Arr::get($groups, App::getLocale());

        if (!$request->has('ref_lang')) {
            $group = Arr::first($groups);
        } else {
            $group = Arr::first(Arr::where($groups, function ($item) use ($request) {
                return $item['locale'] == $request->input('ref_lang');
            }));
        }

        $translations = [];
        if ($group) {
            $jsonFile = resource_path('lang/' . $group['locale'] . '.json');

            if (!File::exists($jsonFile)) {
                $jsonFile = theme_path(Theme::getThemeName() . '/lang/' . $group['locale'] . '.json');
            }

            if (!File::exists($jsonFile)) {
                $languages = scan_folder(theme_path(Theme::getThemeName() . '/lang'));

                if (!empty($languages)) {
                    $jsonFile = theme_path(Theme::getThemeName() . '/lang/' . Arr::first($languages));
                }
            }

            if (File::exists($jsonFile)) {
                $translations = get_file_data($jsonFile, true);
            }

            if ($group['locale'] != 'en') {
                $defaultEnglishFile = theme_path(Theme::getThemeName() . '/lang/en.json');

                if ($defaultEnglishFile) {
                    $translations = array_merge(get_file_data($defaultEnglishFile, true), $translations);
                }
            }
        }

        ksort($translations);

        return view('plugins/translation::theme-translations', compact('translations', 'groups', 'group', 'defaultLanguage'));
    }

    public function postThemeTranslations(Request $request, BaseHttpResponse $response)
    {
        $translations = $request->input('translations', []);

        $json = [];

        foreach ($translations as $translation) {
            $json[$translation['key']] = $translation['value'];
        }

        $jsonFile = resource_path('lang/' . $request->input('locale') . '.json');

        ksort($json);

        $json = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        save_file_data($jsonFile, $json, false);

        return $response
            ->setPreviousUrl(route('translations.theme-translations'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }
}
