<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Controllers\Admin;
use Modules\Payment\Controllers\Shop;
use Modules\Payment\Controllers\Callbacks;

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::apiResource('payments', Admin\PaymentController::class)
            ->only('index', 'show');
        Route::apiResource('card-exchanges', Admin\CardExchangeController::class)
            ->only('index');
        Route::prefix('card-exchanges/{card_exchange}')->group(function () {
            Route::post('send', [Admin\CardExchangeActionController::class, 'send']);
            Route::post('accept', [Admin\CardExchangeActionController::class, 'accept']);
            Route::post('deny', [Admin\CardExchangeActionController::class, 'deny']);
        });
        Route::apiResource('bank-transfers', Admin\BankTransferController::class)
            ->only('index');
        Route::prefix('bank-transfers/{bank_transfer}')->group(function () {
            Route::post('accept', [Admin\BankTransferActionController::class, 'accept']);
            Route::post('deny', [Admin\BankTransferActionController::class, 'deny']);
        });
        Route::apiResource('ewallet-transfers', Admin\EwalletTransferController::class)
            ->only('index');
        Route::prefix('ewallet-transfers/{ewallet_transfer}')->group(function () {
            Route::post('accept', [Admin\EwalletTransferActionController::class, 'accept']);
            Route::post('deny', [Admin\EwalletTransferActionController::class, 'deny']);
        });
        Route::apiResource('payment-methods', Admin\PaymentMethodController::class);
        Route::apiResource('banks', Admin\BankController::class);
        Route::apiResource('cards', Admin\CardController::class);
    });
});

Route::group(['prefix' => 'shop', 'middleware' => 'shop'], function () {
    Route::apiResource('payment-methods', Shop\PaymentMethodController::class)
        ->only('index', 'show');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::apiResource('payments', Shop\PaymentController::class)
            ->only('index', 'store', 'show');
        Route::post('payments/{payment}/cancel', [Shop\PaymentActionController::class, 'cancel']);
        Route::apiResource('card-exchanges', Shop\CardExchangeController::class)
            ->only('index');
        Route::apiResource('bank-transfers', Shop\BankTransferController::class)
            ->only('index', 'update');
        Route::apiResource('ewallet-transfers', Shop\EwalletTransferController::class)
            ->only('index', 'update');
    });
});

Route::group(['prefix' => 'callback'], function () {
    Route::post('bank-transfer', [Callbacks\PaymentCallbackController::class, 'handleBankTransferCallback']);
    Route::post('ewallet-transfer', [Callbacks\PaymentCallbackController::class, 'handleEwalletTransferCallback']);
    Route::post('card-exchange', [Callbacks\PaymentCallbackController::class, 'handleCardExchangeCallback']);
});
