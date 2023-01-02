<?php

use Illuminate\Support\Facades\Route;
use Modules\Shipping\Controllers\Admin;
use Modules\Shipping\Controllers\Shop;

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
    });
});

Route::group(['prefix' => 'shop', 'middleware' => 'shop'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
    });
});
