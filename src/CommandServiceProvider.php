<?php

namespace Oxygencms\Commands;

use Illuminate\Support\ServiceProvider;

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