<?php

use App\Http\Controllers\ShopifyWebhookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'shopify'], function () {
    Route::post('/{shopId}/new-customer', [ShopifyWebhookController::class, 'newCustomer'])->name(
        'shopify.new-customer'
    );
    Route::post('/{shopId}/new-checkout', [ShopifyWebhookController::class, 'newCheckout'])->name(
        'shopify.new-checkout'
    );
});
