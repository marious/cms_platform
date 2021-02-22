<?php
namespace EG\Translation\Providers;

use EG\Base\Traits\LoadAndPublishTrait;
use EG\Translation\Manager;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;
use Event;

class TranslationServiceProvider extends ServiceProvider
{
    use LoadAndPublishTrait;

    public function register()
    {
        $this->app->bind('translation-manger', Manager::class);
    }

    public function boot()
    {
        $this->setNamespace('plugins/translation')
            ->loadAndPublishConfigurations(['general', 'permissions'])
            ->loadMigrations()
            ->loadRoutes(['web'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-plugin-translation',
                    'priority'    => 997,
                    'parent_id'   => null,
                    'name'        => 'plugins/translation::translation.translations',
                    'icon'        => 'fas fa-language',
                    'url'         => route('translations.index'),
                    'permissions' => ['translations.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugin-translation-locale',
                    'priority'    => 1,
                    'parent_id'   => 'cms-plugin-translation',
                    'name'        => 'plugins/translation::translation.locales',
                    'icon'        => null,
                    'url'         => route('translations.locales'),
                    'permissions' => ['translations.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugin-translation-theme-translations',
                    'priority'    => 2,
                    'parent_id'   => 'cms-plugin-translation',
                    'name'        => 'plugins/translation::translation.theme-translations',
                    'icon'        => null,
                    'url'         => route('translations.theme-translations'),
                    'permissions' => ['translations.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugin-translation-admin-translations',
                    'priority'    => 3,
                    'parent_id'   => 'cms-plugin-translation',
                    'name'        => 'plugins/translation::translation.admin-translations',
                    'icon'        => null,
                    'url'         => route('translations.index'),
                    'permissions' => ['translations.index'],
                ]);
        });
    }
}
