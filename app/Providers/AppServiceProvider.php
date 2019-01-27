<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
// use Laravel\Telescope\TelescopeServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Pagination\LengthAwarePaginator::defaultView('vendor.pagination.default');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // if ($this->app->isLocal()) {
        //     $this->app->register(TelescopeServiceProvider::class);
        // }
    }
}
