<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

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
        Model::unguard();
        Model::$snakeAttributes = true;
        Model::preventAccessingMissingAttributes(true);
        Model::preventLazyLoading(true);

        Model::created(function () {
            Cache::forget('dashboard_stats');
            Cache::forget('accounts_list');
        });

        Model::updated(function () {
            Cache::forget('dashboard_stats');
            Cache::forget('accounts_list');
        });

        Model::deleted(function () {
            Cache::forget('dashboard_stats');
            Cache::forget('accounts_list');
        });

    }
}
