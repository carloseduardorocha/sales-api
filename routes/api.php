<?php

use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;

/**
 * /v1 routes group
 */
Route::prefix('v1')->group(function() {
    Route::prefix('auth')->name('auth.')->group(function() {
        Route::controller(AuthController::class)->group(function() {
            Route::post('/login', 'login')->name('login');

            Route::middleware(['auth:sanctum'])->group(function() {
                Route::get('/me', 'me')->name('me');
                Route::post('/logout', 'logout')->name('logout');
            });
        });
    });
});
