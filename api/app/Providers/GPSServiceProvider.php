<?php

namespace App\Providers;

use App\Services\GPS\AISGPSTranslationService;
use App\Services\GPS\MockGPSTranslationService;
use Illuminate\Support\ServiceProvider;

class GPSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') !== 'production') {
            $this->app->bind(
                'GPSTranslationService',
                function() {
                    return new MockGPSTranslationService();
                }
            );
        } else {
            $this->app->bind(
                'GPSTranslationService',
                function() {
                    return new AISGPSTranslationService();
                }
            );
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {


    }
}
