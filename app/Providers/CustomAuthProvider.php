<?php

namespace App\Providers;

use Auth;
use App\User;
use App\Auth\CustomUserProvider;
use Illuminate\Support\ServiceProvider;

class CustomAuthProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->app['auth']->extend('custom',function()
        // {
        //     return new CustomUserProvider('App\User');
        // });
        Auth::extend('custom', function($app)
        {
            return new CustomUserProvider('App\User');
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        return;
    }
}
