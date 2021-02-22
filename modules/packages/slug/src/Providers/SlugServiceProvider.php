<?php

namespace EG\Slug\Providers;

use EG\Base\Supports\Helper;
use EG\Base\Traits\LoadAndPublishTrait;
use Event;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;
use EG\Slug\Models\Slug;
use EG\Slug\Repositories\Caches\SlugCacheDecorator;
use EG\Slug\Repositories\Eloquent\SlugRepository;
use EG\Slug\Repositories\Interfaces\SlugInterface;
use SlugHelper;
use MacroableModels;

class SlugServiceProvider extends ServiceProvider
{
    use LoadAndPublishTrait;

    public function register()
    {
        $this->app->bind(SlugInterface::class, function () {
            return new SlugCacheDecorator(new SlugRepository(new Slug));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('packages/slug')
            ->loadAndPublishConfigurations(['general'])
            ->loadAndPublishViews()
            ->loadRoutes(['web'])
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        $this->app->register(FormServiceProvider::class);
        $this->app->register(HookServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-packages-slug-permalink',
                    'priority'    => 5,
                    'parent_id'   => 'cms-core-settings',
                    'name'        => 'packages/slug::slug.permalink_settings',
                    'icon'        => null,
                    'url'         => route('slug.settings'),
                    'permissions' => ['setting.options'],
                ]);
        });

        $this->app->booted(function () {
            foreach (array_keys(SlugHelper::supportedModels()) as $item) {
                $item::resolveRelationUsing('slugable', function ($model) {
                    return $model->morphOne(Slug::class, 'reference');
                });

                MacroableModels::addMacro($item, 'getSlugAttribute', function () {
                    return $this->slugable ? $this->slugable->key : '';
                });

                MacroableModels::addMacro($item, 'getSlugIdAttribute', function () {
                    return $this->slugable ? $this->slugable->id : '';
                });

                MacroableModels::addMacro($item, 'getSlugItem', function () {
                   return $this->slugable ? $this->slugable : '';
                });

                MacroableModels::addMacro($item, 'getUrlAttribute', function () {
                    $prefix = $this->slugable ? $this->slugable->prefix : null;
                    $prefix = apply_filters(FILTER_SLUG_PREFIX, $prefix);

                    if (!$this->slug) {
                        return url('');
                    }

                    return url($prefix ? $prefix . '/' . $this->slug : $this->slug);
                });
            }
        });
    }
}
