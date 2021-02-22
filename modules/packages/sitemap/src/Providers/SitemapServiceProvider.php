<?php

namespace EG\Sitemap\Providers;

use Carbon\Laravel\ServiceProvider;
use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\DeletedContentEvent;
use EG\Base\Events\UpdatedContentEvent;
use EG\Base\Traits\LoadAndPublishTrait;
use Event;
use EG\Sitemap\Sitemap;

class SitemapServiceProvider extends ServiceProvider
{
    use LoadAndPublishTrait;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->setNamespace('packages/sitemap')
            ->loadAndPublishConfigurations(['config'])
            ->loadAndPublishViews()
            ->publishAssets();

        Event::listen(CreatedContentEvent::class, function () {
            cache()->forget('public.sitemap');
        });

        Event::listen(UpdatedContentEvent::class, function () {
            cache()->forget('public.sitemap');
        });

        Event::listen(DeletedContentEvent::class, function () {
            cache()->forget('public.sitemap');
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('sitemap', function ($app) {
            $config = config('packages.sitemap.config');

            return new Sitemap(
                $config,
                $app['Illuminate\Cache\Repository'],
                $app['config'],
                $app['files'],
                $app['Illuminate\Contracts\Routing\ResponseFactory'],
                $app['view']
            );
        });

        $this->app->alias('sitemap', Sitemap::class);
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['sitemap', Sitemap::class];
    }

}
