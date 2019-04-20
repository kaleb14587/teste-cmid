<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class CustomValidationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
			Validator::extend('file_dat_out', function ($attribute, $value, $parameters, $validator) {
				return preg_match("/(?<=out\/)(.*)(?=.done.dat)/",$value);
			});
    }
}
