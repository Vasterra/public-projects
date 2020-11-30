<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use App\Services\Master;

class MasterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('master', 'App\Services\Master');        
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
