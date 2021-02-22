<?php

namespace EG\Theme\Providers;

use Composer\Autoload\ClassLoader;
use EG\Base\Supports\Helper;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Theme;
use Arr;
use File;

class ThemeManagementServiceProvider extends ServiceProvider
{
    public function register()
    {
        $theme = Theme::getThemeName();
        if (!empty($theme)) {
            $this->app->make('translator')->addJsonPath(theme_path($theme . '/lang'));
        }
    }

    public function boot()
    {
        if (!Theme::getThemeName()) {
            setting()->set('theme', Arr::first(scan_folder(theme_path())));
        }

        $theme = Theme::getThemeName();

        if (!empty($theme)) {
            $themePath = theme_path($theme);

            if (File::exists($themePath . '/theme.json')) {
                $content = get_file_data($themePath . '/theme.json');
                if (!empty($content)) {
                    if (Arr::has($content, 'namespace')) {
                        $loader = new ClassLoader;
                        $loader->setPsr4($content['namespace'], theme_path($theme . '/src'));
                        $loader->register();
                    }
                }
            }

            Helper::autoload(theme_path($theme . '/functions'));
        }
    }
}
