<?php

namespace App\Providers;

use App\Models\SenderIdentity;
use App\Observers\SenderIdentityObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
// use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        SenderIdentity::observe(SenderIdentityObserver::class);
        Paginator::useBootstrap();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Passport::routes();
    }
}
