<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CreateInfoForIndexServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'CreateInfoForIndexService',
            'App\Services\CreateInfoForIndexService'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
