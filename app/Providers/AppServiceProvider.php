<?php

namespace App\Providers;

use App\Models\Sale;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrapFive();

        $package_inactive_customers = Sale::where('package_id', '!=', null)->where('expire_date', '<', date('Y-m-d'))->get();
        view()->share('package_inactive_customers', $package_inactive_customers);
    }
}
