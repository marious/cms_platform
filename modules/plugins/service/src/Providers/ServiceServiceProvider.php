<?php

namespace EG\Service\Providers;

use EG\Base\Traits\LoadAndPublishTrait;
use EG\Service\Models\Service;
use EG\Service\Models\BusinessSolutions;
use Illuminate\Support\ServiceProvider;
use EG\Service\Repositories\Caches\ServiceCacheDecorator;
use EG\Service\Repositories\Eloquent\ServiceRepository;
use EG\Service\Repositories\Interfaces\ServiceInterface;
use EG\Service\Repositories\Interfaces\BusinessSolutionsInterface;
use EG\Service\Repositories\Caches\BusinessSolutionsCacheDecorator;
use EG\Service\Repositories\Eloquent\BusinessSolutionsRepository;
use EG\Base\Supports\Helper;
use Event;
use Illuminate\Routing\Events\RouteMatched;
use SlugHelper;

class ServiceServiceProvider extends ServiceProvider
{
    use LoadAndPublishTrait;

    public function register()
    {
        $this->app->bind(ServiceInterface::class, function () {
            return new ServiceCacheDecorator(new ServiceRepository(new Service));
        });
        $this->app->bind(BusinessSolutionsInterface::class, function () {
            return new BusinessSolutionsCacheDecorator(new BusinessSolutionsRepository(new BusinessSolutions));
        });
        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        SlugHelper::registerModule(BusinessSolutions::class);
        SlugHelper::setPrefix(BusinessSolutions::class, 'business-solutions');

        $this->setNamespace('plugins/service')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([Service::class]);
            }

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-service',
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'plugins/service::service.name',
                'icon'        => 'fa fa-list',
                'url'         => route('service.index'),
                'permissions' => ['service.index'],
            ])
            ->registerItem([
                'id'          => 'cms-plugins-service-service',
                'priority'    => 1,
                'parent_id'   => 'cms-plugins-service',
                'name'        => 'Service',
                'icon'        => null,
                'url'         => route('service.index'),
                'permissions' => ['service.index'],
            ])
            ->registerItem([
                'id'          => 'cms-plugins-service-business-solutions',
                'priority'    => 2,
                'parent_id'   => 'cms-plugins-service',
                'name'        => 'Business solutions',
                'icon'        => null,
                'url'         => route('business-solutions.index'),
                'permissions' => ['service.index'],
            ]);
        });
    }
}
