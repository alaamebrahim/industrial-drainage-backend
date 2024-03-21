<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        //        Model::preventLazyLoading(true);

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

    protected function whereLikeMacro()
    {
        Builder::macro('whereLike', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->when(
                        Str::contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $parts = explode('.', $attribute);

                            $query->orWhereHas($parts[0], function (Builder $query) use ($parts, $searchTerm) {
                                $query->when(count($parts) == 2, function (Builder $query) use ($searchTerm, $parts) {
                                    $query->where($parts[1], 'LIKE', "%{$searchTerm}%");
                                })->when(count($parts) == 3, function (Builder $query) use ($searchTerm, $parts) {
                                    $query->whereHas($parts[1], function (Builder $query) use ($parts, $searchTerm) {
                                        $query->where($parts[2], 'LIKE', "%{$searchTerm}%");
                                    });
                                });
                            });
                        },
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                        }
                    );
                }
            });

            return $this;
        });
    }
}
