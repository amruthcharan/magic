<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShopConfigController;
use App\Http\Controllers\ShopifyController;
use Illuminate\Support\Facades\Route;

// Shopify Guest Routes for installation
Route::group(['middleware' => ['shopify.guest']], function () {
    Route::get('/install', [ShopifyController::class, 'showInstall'])->name('shopify.showInstall');
    Route::post('/install', [ShopifyController::class, 'install'])->name('shopify.install');
});

// Shopify Authenticated Routes
Route::group(['middleware' => ['shopify.auth']], function () {
    Route::get('/', [ShopifyController::class, 'home'])->name('shopify.home');
    Route::get('/generate-token', [ShopifyController::class, 'generateToken'])->name('shopify.generate-token');
    Route::get('/dashboard', [ShopifyController::class, 'dashboard'])->name('shopify.dashboard');
    Route::get('settings', [ShopConfigController::class, 'showSettings'])->name('shopify.settings.show');
    Route::post('settings', [ShopConfigController::class, 'updateSettings'])->name('shopify.settings.update');
    Route::post('/logout', [ShopifyController::class, 'logout'])->name('shopify.logout');
});

// Admin Routes
Route::group(['prefix' => 'admin'], function () {
    // Admin Auth routes for login, logout and password reset
    Auth::routes(['register' => false, 'verify' => false]);
    
    // Admin Dashboard
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('change-password', [DashboardController::class, 'changePassword'])->name('change-password');
        Route::post('change-password', [DashboardController::class, 'passwordChange'])->name('password.change');
    });
});

URL::forceScheme('https');
