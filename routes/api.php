<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ReportController;

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
        Route::prefix('sales')->name('sales.')->group(function() {
            Route::controller(SaleController::class)->group(function() {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');

                Route::get('/seller/{sellerId}/sales', 'getAllSalesBySeller')->name('sales_by_seller');
                Route::get('/seller/{sellerId}/commission', 'getCommissionBySeller')->name('commission_by_seller');
            });
        });

        Route::prefix('reports')->name('reports.')->group(function() {
            Route::controller(ReportController::class)->group(function() {
                Route::post('/admin/{userId}', 'sendAdminReport')->name('send_admin_report');
                Route::post('/seller/{sellerId}', 'sendSellerReport')->name('send_seller_report');
            });
        });
    });
});
