<?php
namespace EG\Setting\Http\Controllers;

use Assets2;
use Illuminate\Http\Request;
use EG\Setting\Supports\SettingStore;
use EG\Base\Http\Controllers\BaseController;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Setting\Http\Requests\MediaSettingRequest;
use EG\Setting\Repositories\Interfaces\SettingInterface;

class SettingController extends BaseController
{
    /**
     * @var SettingInterface
     */
    protected $settingRepository;

    /**
     * @var SettingStore
     */
    protected $settingStore;

     /**
     * SettingController constructor.
     * @param SettingInterface $settingRepository
     * @param SettingStore $settingStore
     */
    public function __construct(SettingInterface $settingRepository, SettingStore $settingStore)
    {
      $this->settingRepository = $settingRepository;
      $this->settingStore = $settingStore;
    }

    public function getOptions()
    {

      page_title()->setTitle(trans('core/setting::setting.title'));

      return view('core/setting::index');
    }


    public function postEdit(Request $request, BaseHttpResponse $response)
    {
        $this->saveSettings($request->except(['_token']));

        return $response
            ->setPreviousUrl(route('settings.options'))
            ->setMessage(trans('core/base::notices.update_success_message'));

    }

    public function saveSettings(array $data)
    {
        foreach ($data as $settingKey => $settingValue) {
          $this->settingStore->set($settingKey, $settingValue);
        }

        $this->settingStore->save();
    }

    public function getEmailConfig()
    {
      page_title()->setTitle(trans('core/base::layouts.setting_email'));
        Assets2::addScriptsDirectly('vendor/core/setting/js/setting.js');
        return view('core/setting::email');
    }

    public function postEditEmailConfig(Request $request, BaseHttpResponse $response)
    {
        $this->saveSettings($request->except(['_token']));

        return $response
                ->setPreviousUrl(route('settings.email'))
                ->setMessage(trans('core/base::notices.update_success_message'));
    }



     /**
     * @return Factory|View
     */
    public function getMediaSetting()
    {
        page_title()->setTitle(trans('core/setting::setting.media.title'));

        Assets2::addScriptsDirectly('vendor/core/core/setting/js/setting.js');

        return view('core/setting::media');
    }

    public function postEditMediaSetting(MediaSettingRequest $request, BaseHttpResponse $response)
    {
          $this->saveSettings($request->except(['_token']));

          return $response
              ->setPreviousUrl(route('settings.media'))
              ->setMessage(trans('core/base::notices.update_success_message'));
    }

}
