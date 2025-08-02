<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(PermissionGuard::class, function ($app) {
            return new PermissionGuard();
        });

        $this->app->singleton(EloquentQueryBuilder::class, function ($app) {
            return new EloquentQueryBuilder();
        });

        $this->app->singleton(QueryRunner::class, function ($app) {
            return new QueryRunner($app->make(Request::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
