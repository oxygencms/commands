<?php

namespace Oxygencms\Commands;

use Illuminate\Support\ServiceProvider;
use Oxygencms\Commands\Commands\OxyAdminControllerMakeCommand;
use Oxygencms\Commands\Commands\OxyAdminRequestMakeCommand;
use Oxygencms\Commands\Commands\OxyControllerMakeCommand;
use Oxygencms\Commands\Commands\OxyMakeCommand;
use Oxygencms\Commands\Commands\OxyPolicyMakeCommand;

class CommandServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                OxyAdminControllerMakeCommand::class,
                OxyAdminRequestMakeCommand::class,
                OxyControllerMakeCommand::class,
                OxyPolicyMakeCommand::class,
                OxyMakeCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/commands' => app_path('Console/Commands/OxyCommands'),
        ], 'commands');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
