<?php

use Illuminate\Support\Facades\Route;
use Modules\Inbox\Controllers\Admin;
use Modules\Inbox\Controllers\Shop;

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::apiResource('threads', Admin\ThreadController::class);
        Route::post('threads/{thread}/seen', [Admin\ThreadController::class, 'seen']);
        Route::get('order-items/{order_item}/thread', [Admin\OrderItemThreadController::class, 'show']);
        Route::apiResource('threads.messages', Admin\ThreadMessageController::class)
            ->only('index', 'store');
        Route::apiResource('threads.notes', Admin\ThreadNoteController::class)
            ->only('index', 'store', 'update', 'destroy');
    });
});

Route::group(['prefix' => 'shop', 'middleware' => 'shop'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('threads/{thread}/seen', [Admin\ThreadController::class, 'seen']);
        Route::get('order-items/{order_item}/thread', [Shop\OrderItemThreadController::class, 'show']);
        Route::apiResource('threads.messages', Shop\ThreadMessageController::class)
            ->only('index', 'store');
    });
});
