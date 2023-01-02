<?php

use Illuminate\Support\Facades\Route;
use Modules\Inventory\Controllers\Admin;

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::apiResource('inventories', Admin\InventoryController::class)
            ->only('index', 'show');
        Route::apiResource('inventories.items', Admin\InventoryInventoryItemController::class)
            ->only('store');
        Route::apiResource('inventory-items', Admin\InventoryItemController::class);
        Route::delete('inventory-items', [Admin\BulkInventoryItemController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'shop', 'middleware' => 'shop'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
    });
});
