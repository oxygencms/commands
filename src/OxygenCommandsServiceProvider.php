<?php

namespace Oxygencms\Commands;

use Illuminate\Support\ServiceProvider;

class OxygenCommandsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
//        if ($this->app->runningInConsole()) {
//            $this->commands([
//                FooCommand::class,
//                BarCommand::class,
//            ]);
//        }
        info('dfsgdsfg');
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