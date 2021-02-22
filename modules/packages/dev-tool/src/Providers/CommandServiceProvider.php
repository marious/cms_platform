<?php

namespace EG\DevTool\Providers;

use EG\DevTool\Commands\InstallCommand;
use EG\DevTool\Commands\LocaleCreateCommand;
use EG\DevTool\Commands\LocaleRemoveCommand;
use EG\DevTool\Commands\Make\ControllerMakeCommand;
use EG\DevTool\Commands\Make\FormMakeCommand;
use EG\DevTool\Commands\Make\ModelMakeCommand;
use EG\DevTool\Commands\Make\RepositoryMakeCommand;
use EG\DevTool\Commands\Make\RequestMakeCommand;
use EG\DevTool\Commands\Make\RouteMakeCommand;
use EG\DevTool\Commands\Make\TableMakeCommand;
use EG\DevTool\Commands\PackageCreateCommand;
use EG\DevTool\Commands\PackageRemoveCommand;
use EG\DevTool\Commands\RebuildPermissionsCommand;
use EG\DevTool\Commands\TestSendMailCommand;
use EG\DevTool\Commands\TruncateTablesCommand;
use EG\DevTool\Commands\PackageMakeCrudCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                TableMakeCommand::class,
                ControllerMakeCommand::class,
                RouteMakeCommand::class,
                RequestMakeCommand::class,
                FormMakeCommand::class,
                ModelMakeCommand::class,
                RepositoryMakeCommand::class,
                PackageCreateCommand::class,
                PackageMakeCrudCommand::class,
                PackageRemoveCommand::class,
                InstallCommand::class,
                TestSendMailCommand::class,
                TruncateTablesCommand::class,
                RebuildPermissionsCommand::class,
                LocaleRemoveCommand::class,
                LocaleCreateCommand::class,
            ]);
        }
    }
}
