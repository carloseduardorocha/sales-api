<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerController;

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

    Route::middleware(['auth:sanctum'])->group(function() {
        Route::prefix('sellers')->name('sellers.')->group(function() {
            Route::controller(SellerController::class)->group(function() {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });
        });
    });
});
