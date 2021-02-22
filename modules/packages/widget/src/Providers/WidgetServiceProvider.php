<?php

namespace EG\Widget\Providers;

use Carbon\Laravel\ServiceProvider;
use EG\Base\Supports\Helper;
use EG\Base\Traits\LoadAndPublishTrait;
use Event;
use File;
use Illuminate\Routing\Events\RouteMatched;
use EG\Widget\Factories\WidgetFactory;
use EG\Widget\Misc\LaravelApplicationWrapper;
use EG\Widget\Models\Widget;
use EG\Widget\Repositories\Caches\WidgetCacheDecorator;
use EG\Widget\Repositories\Eloquent\WidgetRepository;
use EG\Widget\Repositories\Interfaces\WidgetInterface;
use EG\Widget\WidgetGroupCollection;
use EG\Widget\Widgets\Text;
use WidgetGroup;
use Theme;

class WidgetServiceProvider extends ServiceProvider
{
    use LoadAndPublishTrait;

    public function register()
    {
        $this->app->bind(WidgetInterface::class, function () {
            return new WidgetCacheDecorator(new WidgetRepository(new Widget));
        });

        $this->app->bind('packages.widget', function () {
            return new WidgetFactory(new LaravelApplicationWrapper);
        });

        $this->app->singleton('packages.widget-group-collection', function () {
            return new WidgetGroupCollection(new LaravelApplicationWrapper);
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('packages/widget')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadRoutes(['web'])
            ->loadMigrations()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets();

        $this->app->booted(function () {

            WidgetGroup::setGroup([
                'id'          => 'primary_sidebar',
                'name'        => 'Primary sidebar',
                'description' => 'This is primary sidebar section',
            ]);

            register_widget(Text::class);

            $widgetPath = theme_path(Theme::getThemeName() . '/widgets');
            $widgets = scan_folder($widgetPath);
            if (!empty($widgets) && is_array($widgets)) {
                foreach ($widgets as $widget) {
                    $registration = $widgetPath . '/' . $widget . '/registration.php';
                    if (File::exists($registration)) {
                        File::requireOnce($registration);
                    }
                }
            }
        });

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-core-widget',
                    'priority'    => 3,
                    'parent_id'   => 'cms-core-appearance',
                    'name'        => 'core/base::layouts.widgets',
                    'icon'        => null,
                    'url'         => route('widgets.index'),
                    'permissions' => ['widgets.index'],
                ]);

            if (function_exists('admin_bar')) {
                admin_bar()->registerLink(trans('core/base::layouts.widgets'), route('widgets.index'), 'appearance');
            }
        });
    }


}
