<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Notification;
use Illuminate\Support\Facades\Auth;

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
        // view()->composer('*', function ($view) {
        //     $view->with('notifications', Notification::where('recievers_user_id', Auth::user()->id)
        //         ->take(10)
        //         ->get());
        // });
    }
}
