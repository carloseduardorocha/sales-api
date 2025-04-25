<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /** Register any application services. */
    public function register(): void
    {
        $this->app->bind(
            \App\Contracts\AuthContract::class,
            \App\Services\AuthService::class,
        );

        $this->app->bind(
            \App\Contracts\SellerContract::class,
            \App\Services\SellerService::class,
        );

        $this->app->bind(
            \App\Contracts\SaleContract::class,
            \App\Services\SaleService::class,
        );

        $this->app->bind(
            \App\Contracts\ReportContract::class,
            \App\Services\ReportService::class,
        );
    }

    /** Bootstrap any application services. */
    public function boot(): void
    {
    }
}
