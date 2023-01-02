<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Controllers\Admin;
use Modules\User\Controllers\Shop;

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::post('token', [Admin\TokenController::class, 'store']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::delete('token', [Admin\TokenController::class, 'destroy']);

        Route::get('me', [Admin\MeController::class, 'show']);
        Route::put('me', [Admin\MeController::class, 'update']);

        Route::apiResource('users', Admin\UserController::class);
        Route::apiResource('roles', Admin\RoleController::class);
        Route::apiResource('permissions', Admin\PermissionController::class)
            ->only('index');
        Route::apiResource('users.roles', Admin\UserRoleController::class)
            ->only('index', 'store', 'destroy');
        Route::put('users/{user}/wallet', [Admin\UserWalletController::class, 'update']);
        Route::apiResource('transactions', Admin\TransactionController::class)
            ->only('index');
    });
});

Route::group(['prefix' => 'shop', 'middleware' => 'shop'], function () {
    Route::post('token', [Shop\TokenController::class, 'store']);

    Route::apiResource('customers', Shop\CustomerController::class)
        ->only('store');
    Route::apiResource('verification-codes', Shop\VerificationCodeController::class)
        ->only('store');

    Route::apiResource('password-resets', Shop\PasswordResetController::class)
        ->only('store', 'update');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::delete('token', [Shop\TokenController::class, 'destroy']);

        Route::get('me', [Shop\MeController::class, 'show']);
        Route::put('me', [Shop\MeController::class, 'update']);

        Route::delete('token', [Shop\TokenController::class, 'destroy']);

        Route::apiResource('login-histories', Shop\LoginHistoryController::class)
            ->only('index');
        Route::apiResource('identify-providers', Shop\IdentifyProviderController::class)
            ->only('index', 'store', 'destroy');
        Route::apiResource('transactions', Shop\TransactionController::class)
            ->only('index');
        Route::apiResource('wishlists', Shop\WishlistController::class)
            ->only('index', 'store', 'destroy');
    });
});
