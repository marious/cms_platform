<?php
namespace EG\Table\Providers;

use EG\Base\Supports\Helper;
use Illuminate\Support\ServiceProvider;
use EG\Base\Traits\LoadAndPublishTrait;

class TableServiceProvider extends ServiceProvider
{
    use LoadAndPublishTrait;


    public function boot()
    {
        Helper::autoload(__DIR__ . '/../../helpers');

        $this->setNamespace('core/table')
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web'])
            ->publishAssets();
    }
}
