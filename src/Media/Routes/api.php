<?php

use Illuminate\Support\Facades\Route;
use Modules\Media\Controllers\FileController;

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::apiResource('files', FileController::class)
            ->only('store');
    });
});

Route::group(['prefix' => 'shop', 'middleware' => 'shop'], function () {
    Route::apiResource('files', FileController::class)
        ->only('store');

    Route::group(['middleware' => 'auth:sanctum'], function () {
    });
});
