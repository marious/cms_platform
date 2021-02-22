<?php

namespace EG\Slug\Providers;

use Illuminate\Support\ServiceProvider;
use EG\Slug\Commands\ChangeSlugPrefixCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ChangeSlugPrefixCommand::class,
            ]);
        }
    }
}
