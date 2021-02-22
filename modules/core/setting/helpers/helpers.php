<?php
use EG\Setting\Facades\SettingFacade;

if (!function_exists('setting')) {
  /**
   * Get the setting instance.
   *
   * @param string|null $key
   * @param string|null $default
   * @return array|\EG\Setting\Supports\SettingStore|string|null
   */
  function setting($key = null, $default = null)
  {
      if (!empty($key)) {
          try {
              return Setting::get($key, $default);
          } catch (Exception $exception) {
              return $default;
          }
      }

      return SettingFacade::getFacadeRoot();
  }
}
