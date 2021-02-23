<?php
namespace EG\SimpleSlider\Providers;

use EG\Base\Supports\Helper;
use EG\Base\Traits\LoadAndPublishTrait;
use EG\SimpleSlider\Models\SimpleSlider;
use EG\SimpleSlider\Models\SimpleSliderItem;
use EG\SimpleSlider\Repositories\Caches\SimpleSliderCacheDecorator;
use EG\SimpleSlider\Repositories\Caches\SimpleSliderItemCacheDecorator;
use EG\SimpleSlider\Repositories\Eloquent\SimpleSliderItemRepository;
use EG\SimpleSlider\Repositories\Eloquent\SimpleSliderRepository;
use EG\SimpleSlider\Repositories\Interfaces\SimpleSliderInterface;
use EG\SimpleSlider\Repositories\Interfaces\SimpleSliderItemInterface;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;
use Event;
use Language;

class SimpleSliderServiceProvider extends ServiceProvider
{
    use LoadAndPublishTrait;

    public function register()
    {
        $this->app->bind(SimpleSliderInterface::class, function () {
            return new SimpleSliderCacheDecorator(new SimpleSliderRepository(new SimpleSlider));
        });

        $this->app->bind(SimpleSliderItemInterface::class, function () {
            return new SimpleSliderItemCacheDecorator(new SimpleSliderItemRepository(new SimpleSliderItem));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/simple-slider')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web'])
            ->loadMigrations()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-simple-slider',
                'priority'    => 100,
                'parent_id'   => null,
                'name'        => 'plugins/simple-slider::simple-slider.menu',
                'icon'        => 'far fa-image',
                'url'         => route('simple-slider.index'),
                'permissions' => ['simple-slider.index'],
            ]);
        });
        $this->app->booted(function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                Language::registerModule([SimpleSlider::class]);
            }

//            $this->app->register(HookServiceProvider::class);
        });

    }
}
