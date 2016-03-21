<?php

namespace AldoZumaran\Acl;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AclServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/acl.php' => config_path('acl.php'),
        ]);

        $this->publishes([
            __DIR__.'/Models' => app_path('Models/Acl'),
        ], 'models');

        $this->publishes([
            __DIR__.'/assets' => public_path('vendor/aldozumaran/acl'),
        ], 'public');

        $this->publishes([
            __DIR__.'/database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->loadViewsFrom(__DIR__.'/views', 'acl');

        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/aldozumaran/acl'),
        ]);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        App::singleton('Acl', function($app)
        {
            return new Acl();
        });
    }
}
