<?php

namespace Kang\LaravelMobileDetect;

use Illuminate\Support\ServiceProvider;

/**
 * Class MobileDetectServiceProvider
 * @package Kang\LaravelMobileDetect
 */
class MobileDetectServiceProvider extends ServiceProvider {

    /**
     * Boot the service provider.
     *
     * @return null
     */
    public function boot()
    {
        // Publish configuration files
        $this->publishes([
            __DIR__.'/../config/mobiledetect.php' => config_path('mobiledetect.php')
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Merge configs
        $this->mergeConfigFrom(
            __DIR__.'/../config/mobiledetect.php', 'mobiledetect'
        );

        // Bind mobiledetect
        $this->app->bind('MobileDetect', function($app)
        {
            return new MobileDetect($app['config']);
        });
    }

}
