<?php
namespace EG\Base\Providers;

use EG\Base\Repositories\Caches\MetaBoxCacheDecorator;
use EG\Base\Repositories\Eloquent\MetaBoxRepository;
use EG\Base\Repositories\Interfaces\MetaBoxInterface;
use EG\Base\Supports\BreadcrumbsManager;
use EG\Setting\Supports\SettingStore;
use Event;
use EG\Base\Supports\Helper;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use EG\Base\Traits\LoadAndPublishTrait;
use Illuminate\Routing\ResourceRegistrar;
use Illuminate\Routing\Events\RouteMatched;
use EG\Base\Facades\MacroableModelsFacade;
use EG\Base\Http\Middleware\CoreMiddleware;
use EG\Base\Supports\CustomResourceRegistrar;
use EG\Setting\Providers\SettingServiceProvider;
use EG\Base\Models\MetaBox as MetaBoxModel;
use MetaBox;


class BaseServiceProvider extends ServiceProvider
{
    use LoadAndPublishTrait;

    protected $defer = true;

    public function register()
    {
        $this->app->bind(ResourceRegistrar::class, function ($app) {
            return new CustomResourceRegistrar($app['router']);
        });

        Helper::autoload(__DIR__ . '/../../helpers');

        $this->setNamespace('core/base')
            ->loadAndPublishConfigurations(['general', 'multiLang']);

        $this->app->register(SettingServiceProvider::class);

        $this->app->singleton(BreadcrumbsManager::class, BreadcrumbsManager::class);

        $this->app->bind(MetaBoxInterface::class, function () {
            return new MetaBoxCacheDecorator(new MetaBoxRepository(new MetaBoxModel));
        });
    }

    public function boot()
    {
        $this->setNamespace('core/base')
          ->loadAndPublishConfigurations(['permissions', 'assets'])
          ->loadAndPublishViews()
          ->loadAndPublishTranslations()
          ->loadRoutes(['web'])
          ->loadMigrations()
          ->publishAssets();

        $this->app->booted(function () {
            do_action(BASE_ACTION_INIT);
            add_action(BASE_ACTION_META_BOXES, [MetaBox::class, 'doMetaBoxes'], 8, 2);

            $config = $this->app->make('config');
            $setting = $this->app->make(SettingStore::class);
            $config->set([
                'app.locale'        => setting('locale', $config->get('core.base.general.locale', $config->get('app.locale'))),
                'app.timezone'      => $setting->get('time_zone', $config->get('app.timezone')),
            ]);
        });


        $router = $this->app['router'];
        $router->middlewareGroup('core', [CoreMiddleware::class]);

        Event::listen(RouteMatched::class, function () {
            $this->registerDefaultMenus();
        });

        AliasLoader::getInstance()->alias('MacroableModels', MacroableModelsFacade::class);
    }

    public function registerDefaultMenus()
    {
        dashboard_menu()->registerItem([
            'id'          => 'cms-core-platform-administration',
            'priority'    => 999,
            'parent_id'   => null,
            'name'        => 'core/base::layouts.platform_admin',
            'icon'        => 'fa fa-user',
            'url'         => null,
            'permissions' => ['users.index']
        ])
         ->registerItem([
             'id'          => 'cms-core-system-information',
             'priority'    => 5,
             'parent_id'   => 'cms-core-platform-administration',
             'name'        => 'core/base::system.info.title',
             'icon'        => null,
             'url'         => route('system.info'),
             'permissions' => [ACL_ROLE_SUPER_USER],
         ])
         ->registerItem([
             'id'          => 'cms-core-system-cache',
             'priority'    => 6,
             'parent_id'   => 'cms-core-platform-administration',
             'name'        => 'core/base::cache.cache_management',
             'icon'        => null,
             'url'         => route('system.cache'),
             'permissions' => [ACL_ROLE_SUPER_USER],
         ]);

    }

    /**
     * @return array|string[]
     */
    public function provides(): array
    {
        return [BreadcrumbsManager::class];
    }
}
