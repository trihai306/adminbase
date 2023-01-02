<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Controllers\Admin;
use Modules\Order\Controllers\Shop;

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::apiResource('orders', Admin\OrderController::class)
            ->only('index', 'show');
        Route::apiResource('order-items', Admin\OrderItemController::class)
            ->only('index', 'show');
        Route::prefix('order-items/{order_item}')->group(function () {
            Route::post('process', [Admin\OrderItemActionController::class, 'process']);
            Route::post('complete', [Admin\OrderItemActionController::class, 'complete']);
            Route::post('delivery', [Admin\OrderItemActionController::class, 'delivery']);
            Route::post('cancel', [Admin\OrderItemActionController::class, 'cancel']);
        });
        Route::apiResource('order-items.delivery-inventory-items', Admin\OrderDeliveryInventoryItemController::class)
            ->only('index', 'store');
        Route::apiResource('order-item-statuses', Admin\OrderItemStatusController::class)
            ->only('index');
    });
});

Route::group(['prefix' => 'shop', 'middleware' => 'shop'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::apiResource('orders', Shop\OrderController::class)
            ->only('index', 'store', 'show');
        Route::apiResource('order-items', Shop\OrderItemController::class)
            ->only('index', 'show');
        Route::apiResource('order-item-statuses', Shop\OrderItemStatusController::class)
            ->only('index');
    });
});
