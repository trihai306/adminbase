<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('settings', [\Modules\Setting\Controllers\Admin\SettingController::class, 'show']);
        Route::put('settings', [\Modules\Setting\Controllers\Admin\SettingController::class, 'update']);
    });
});

Route::group(['prefix' => 'shop', 'middleware' => 'shop'], function () {
    Route::get('settings', [\Modules\Setting\Controllers\Shop\SettingController::class, 'show']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
    });
});
