<?php

namespace aliamini78\ModuleBuilder;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ModuleBuilderServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {

        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\MakeModule::class,
            ]);
        }
    }

}