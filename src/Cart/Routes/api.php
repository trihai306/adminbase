<?php

use Illuminate\Support\Facades\Route;
use Modules\Cart\Controllers\Admin;
use Modules\Cart\Controllers\Shop;

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
    });
});

Route::group(['prefix' => 'shop', 'middleware' => 'shop'], function () {
    Route::apiResource('carts', Shop\CartController::class)
        ->only('store', 'show');
    Route::apiResource('carts.items', Shop\CartItemController::class)
        ->only('store', 'update', 'destroy');

    Route::group(['middleware' => 'auth:sanctum'], function () {
    });
});
