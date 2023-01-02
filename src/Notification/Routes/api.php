<?php

use Illuminate\Support\Facades\Route;
use Modules\Notification\Controllers\Admin;
use Modules\Notification\Controllers\Shop;

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::apiResource('notifications', Admin\NotificationController::class)
            ->only('index');
        Route::post('notifications/read', [Admin\NotificationController::class, 'markAsRead']);
    });
});

Route::group(['prefix' => 'shop', 'middleware' => 'shop'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::apiResource('notifications', Shop\NotificationController::class)
            ->only('index');
        Route::post('notifications/read', [Shop\NotificationController::class, 'markAsRead']);
    });
});
