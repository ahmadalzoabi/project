<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User; //new
use App\Observers\UserObsrver; //new

use Schema; //new

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Schema::defaultStringLength(191); //new
        User::observe(UserObsrver::class); //new

    }
}
