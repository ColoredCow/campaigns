<?php

namespace App\Providers;

use App\Models\SenderIdentity;
use Illuminate\Support\ServiceProvider;
use App\Observers\SenderIdentityObserver;

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
