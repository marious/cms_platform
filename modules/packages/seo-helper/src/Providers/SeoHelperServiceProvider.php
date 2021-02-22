<?php

namespace EG\SeoHelper\Providers;

use EG\SeoHelper\SeoOpenGraph;
use EG\SeoHelper\SeoTwitter;
use EG\Base\Supports\Helper;
use EG\Base\Traits\LoadAndPublishTrait;
use Illuminate\Support\ServiceProvider;
use EG\SeoHelper\Contracts\SeoHelperContract;
use EG\SeoHelper\Contracts\SeoMetaContract;
use EG\SeoHelper\Contracts\SeoOpenGraphContract;
use EG\SeoHelper\Contracts\SeoTwitterContract;
use EG\SeoHelper\SeoHelper;
use EG\SeoHelper\SeoMeta;

class SeoHelperServiceProvider extends ServiceProvider
{
    use LoadAndPublishTrait;

    public function register()
    {
        $this->app->bind(SeoMetaContract::class, SeoMeta::class);
        $this->app->bind(SeoHelperContract::class, SeoHelper::class);
        $this->app->bind(SeoOpenGraphContract::class, SeoOpenGraph::class);
        $this->app->bind(SeoTwitterContract::class, SeoTwitter::class);

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('packages/seo-helper')
            ->loadAndPublishConfigurations(['general'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets();

        $this->app->register(HookServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
    }
}
