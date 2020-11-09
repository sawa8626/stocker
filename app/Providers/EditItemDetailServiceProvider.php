<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EditItemDetailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'EditItemDetailService',
            'App\Services\EditItemDetailService'
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
