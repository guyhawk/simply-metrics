<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Counter;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $counters = Counter::query()->get(['id','site_name']);
        View::share('counters_list', $counters);

        // View::composer('dashboard*', function($view) {
        //     $view->with('counters_list',  $counters);
        // });
    }
}
