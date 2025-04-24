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
    }

    /** Bootstrap any application services. */
    public function boot(): void
    {
    }
}
