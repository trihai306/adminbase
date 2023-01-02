<?php

use Illuminate\Support\Facades\Route;
use Modules\Catalog\Controllers\Admin;
use Modules\Catalog\Controllers\Shop;

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::apiResource('categories', Admin\CategoryController::class);
        Route::apiResource('category-trees', Admin\CategoryTreeController::class);
        Route::apiResource('category-tags', Admin\CategoryTagController::class);
        Route::apiResource('collections', Admin\CollectionController::class);
        Route::apiResource('brands', Admin\BrandController::class);
        Route::apiResource('attributes', Admin\AttributeController::class);
        Route::apiResource('options', Admin\OptionController::class);
        Route::apiResource('products', Admin\ProductController::class);
        Route::apiResource('products.related-products', Admin\ProductRelatedProductController::class)
            ->only('index');
        Route::get('products/{product}/content', [Admin\ProductController::class, 'showContent']);
        Route::apiResource('variants', Admin\VariantController::class);
        Route::apiResource('reviews', Admin\ReviewController::class)
            ->only('index', 'destroy');
        Route::apiResource('promotions', Admin\PromotionController::class);
        Route::apiResource('vouchers', Admin\VoucherController::class);
        Route::apiResource('history-points', Admin\HistoryPointController::class)->only('index','show');

    });
});

Route::group(['prefix' => 'shop', 'middleware' => 'shop'], function () {
    Route::apiResource('categories', Shop\CategoryController::class)
        ->only('index', 'show');
    Route::apiResource('categories.children-tags', Shop\CategoryChildrenTagController::class)
        ->only('index');
    Route::apiResource('category-trees', Shop\CategoryTreeController::class)
        ->only('index');
    Route::apiResource('collections', Shop\CollectionController::class)
        ->only('index', 'show');
    Route::apiResource('options', Shop\OptionController::class)
        ->only('index', 'show');
    Route::get('collections/hom-nay-co-gi/products', [Shop\CollectionProductController::class, 'indexNewest']);
    Route::get('collections/goi-y-cho-ban/products', [Shop\CollectionProductController::class, 'indexRecommendation']);
    Route::get('collections/ban-chay/products', [Shop\CollectionProductController::class, 'indexBestselling']);
    Route::get('collections/duoi-100k/products', [Shop\CollectionProductController::class, 'indexUnder100k']);
    Route::get('collections/danh-gia-cao/products', [Shop\CollectionProductController::class, 'indexHighReview']);
    Route::apiResource('collections.products', Shop\CollectionProductController::class)
        ->only('index');
    Route::apiResource('products', Shop\ProductController::class)
        ->only('index', 'show');
    Route::apiResource('products.reviews', Shop\ProductReviewController::class)
        ->only('index');
    Route::apiResource('products.related-products', Shop\ProductRelatedProductController::class)
        ->only('index');
    Route::get('products/{product}/content', [Shop\ProductController::class, 'showContent']);
    Route::apiResource('variants', Shop\VariantController::class)
        ->only('index', 'show');
    Route::apiResource('reviews', Shop\ReviewController::class)
        ->only('index');
    Route::apiResource('promotions', Shop\PromotionController::class)
        ->only('index', 'show');


    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('exchange-points', [Shop\VoucherController::class,'listVoucherExchange']);
        Route::apiResource('vouchers', Shop\VoucherController::class)
            ->only('index', 'show');
        Route::apiResource('user-vouchers', Shop\UserVoucherController::class)
            ->only('index','show');
        Route::apiResource('history-points', Shop\HistoryPointController::class)
            ->only('index');
        Route::post('voucher/{id}/user',[Shop\VoucherController::class,'userByVoucher']);
        Route::apiResource('reviews', Shop\ReviewController::class)
            ->only('store');
    });

});


