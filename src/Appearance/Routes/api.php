<?php

use Illuminate\Support\Facades\Route;
use Modules\Appearance\Controllers\Admin;
use Modules\Appearance\Controllers\Shop;

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::apiResource('slides', Admin\SlideController::class);
        Route::apiResource('menus', Admin\MenuController::class);
    });
});

Route::group(['prefix' => 'shop', 'middleware' => 'shop'], function () {
    Route::apiResource('slugs', Shop\SlugController::class)
        ->only('index', 'show');
    Route::get('/slugs/{prefix}/{slug}', [Shop\SlugController::class, 'showSlug']);
    Route::apiResource('slides', Shop\SlideController::class)
        ->only('index', 'show');
    Route::apiResource('menus', Admin\MenuController::class)
        ->only('index', 'show');

    Route::group(['middleware' => 'auth:sanctum'], function () {
    });
});
