<?php

namespace Lersoft\LaravelThumbnail;

use Illuminate\Support\ServiceProvider;

class LaravelThumbnailServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/thumb.php' => config_path('thumb.php'),
        ], 'config');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind("thumbnail", \Lersoft\LaravelThumbnail\LaravelThumbnail::class);
    }
}