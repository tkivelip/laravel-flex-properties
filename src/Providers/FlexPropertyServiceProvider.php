<?php

namespace tkivelip\LaravelFlexProperties\Providers;

use Illuminate\Support\ServiceProvider;

class MultilingualServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            //$this->registerPublishing();
            $this->loadMigrationsFrom(__DIR__.'/../../migrations');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'laravel-multilingual');
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('laravel-multilingual.php'),
        ], 'laravel-multilingual-config');
        $this->publishes([
            __DIR__.'/../../migrations' => database_path('migrations'),
        ], 'laravel-multilingual-migrations');
    }
}
