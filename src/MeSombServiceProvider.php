<?php

namespace FreeThinkerz\LaravelPay;

use Illuminate\Support\ServiceProvider;

class MeSombServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap app.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPublishing();
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }

    /**
     * Publish assets and config.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        $this->publishes(
            [
                __DIR__ . '/../config/laravel-pay.php' => config_path('laravel-pay.php'),
            ],
            'mesomb-configuration'
        );
    }

    /**
     * Register Package Configuration.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/laravel-pay.php',
            'mesomb'
        );
    }
}
