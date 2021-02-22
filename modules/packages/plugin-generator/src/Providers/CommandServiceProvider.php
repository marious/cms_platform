<?php

namespace EG\PluginGenerator\Providers;

use EG\PluginGenerator\Commands\PluginCreateCommand;
use EG\PluginGenerator\Commands\PluginListCommand;
use EG\PluginGenerator\Commands\PluginMakeCrudCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PluginListCommand::class,
                PluginCreateCommand::class,
                PluginMakeCrudCommand::class,
            ]);
        }
    }
}
