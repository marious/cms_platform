<?php
namespace EG\Base\Providers;

use Assets2;
use Illuminate\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot(Factory $view)
    {
        $view->composer(['core/base::layouts.partials.top-header'], function (View $view) {
          Assets2::addStylesDirectly('vendor/core/base/css/theme/default.css');
        });
    }
}
