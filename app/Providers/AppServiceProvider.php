<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Registering CustomService 
        $this->app->singleton('CustomServices', function ($app) {
            return new \App\Services\CustomServices\CustomServices;
        });
        //Registering our GenericResponses File as a Service Provider
        $this->app->singleton('GenericResponses', function ($app) {
            return new \App\Services\GenericResponses\GenericResponses;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
