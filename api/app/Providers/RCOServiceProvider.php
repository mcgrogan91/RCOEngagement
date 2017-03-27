<?php

namespace App\Providers;

use App\Services\RCO\{
    GISRCOTranslationService,
    MockRCOTranslationService
};
use Illuminate\Support\ServiceProvider;

class RCOServiceProvider extends ServiceProvider
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
                'RCOTranslationService',
                function() {
                    return new MockRCOTranslationService();
                }
            );
        } else {
            $this->app->bind(
                'RCOTranslationService',
                function() {
                    return new GISRCOTranslationService();
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
