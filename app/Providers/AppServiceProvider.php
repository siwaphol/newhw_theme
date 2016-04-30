<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('section3', function($attribute, $value, $parameters, $validator) {
            foreach ($value as $section){
                if(strlen($section)!=3){
                    return false;
                }
            }
            return true;
        });

        Validator::replacer('section3', function($message, $attribute, $rule, $parameters) {
            return "section number must has length of 3";
        });

        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
