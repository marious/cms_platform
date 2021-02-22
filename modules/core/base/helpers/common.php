<?php
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use EG\Base\Facades\PageTitleFacade;
use EG\Base\Facades\DashboardMenuFacade;

if (!function_exists('anchor_link')) {
    /**
     * @param string $link
     * @param string $name
     * @param array $options
     * @return string
     * @throws Throwable
     * @deprecated
     */
    function anchor_link(?string $link, ?string $name, array $options = []): string
    {
        return Html::link($link, $name, $options);
    }
}

if (!function_exists('language_flag')) {
    /**
     * @param string $flag
     * @param string $name
     * @return string
     */
    function language_flag(string $flag, ?string $name = null): string
    {
        return Html::image(url(BASE_LANGUAGE_FLAG_PATH . $flag . '.svg'), $name, ['title' => $name, 'width' => 16]);
    }
}


if (!function_exists('modules_path')) {
  function modules_path($path = null) {
    return base_path('modules/' . $path);
  }
}

if (!function_exists('core_path')) {
    function core_path($path = null) {
        return modules_path('core/' . $path);
    }
}

if (!function_exists('package_path')) {
    function package_path($path = null) {
        return modules_path('packages/' . $path);
    }
}



if (!function_exists('is_in_admin')) {
  function is_in_admin(): bool
  {
      $isInAdmin = request()->segment(1) === BaseHelper::getAdminPrefix();
      return apply_filters(IS_IN_ADMIN_FILTER, $isInAdmin);
  }
}

if (!function_exists('page_title')) {
  /**
   * @return mixed|object
   */
  function page_title()
  {
      return PageTitleFacade::getFacadeRoot();
  }
}

if (!function_exists('dashboard_menu')) {
  /**
   * @return mixed|object
   */
  function dashboard_menu() {
      return DashboardMenuFacade::getFacadeRoot();
  }
}

if (!function_exists('get_app_version')) {
  function get_app_version(): string {
      try {
          return trim(get_file_data(base_path('VERSION'), false));
      } catch (Exception $e) {
          return '1.0';
      }
  }
}


