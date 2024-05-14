<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\User\CategoryUserController;
use App\Http\Controllers\User\StoreUserController;
use App\Http\Controllers\User\ProductUserController;
use App\Http\Controllers\User\CouponUserController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StoreController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Route::get('/store-user', [StoreUserController::class, 'index']);
Route::get('/category-user', [CategoryUserController::class, 'index']);
Route::get('/product-user', [ProductUserController::class, 'index']);
Route::get('/coupon-user', [CouponUserController::class, 'index']);
Route::get('/store-active', [StoreUserController::class, 'storeActive']);
Route::get('/store-featured', [StoreUserController::class, 'storeFeatured']);
Route::get('/store-user', [StoreUserController::class, 'allStore']);
Route::get('/coupon-active', [CouponUserController::class, 'couponActive']);
Route::get('/coupon-fatured', [CouponUserController::class, 'couponFatured']);
Route::get('/store-user/{store}', [StoreUserController::class, 'storeBYcoupon']);
Route::get('/category-user/{category}', [CategoryUserController::class, 'show']);

Route::get('/search-store/{name}', [StoreUserController::class, 'search']);


Route::get('get-lang', [StoreUserController::class, 'language']);
Route::post('change-lang', [StoreUserController::class, 'changelang']);

// Route::post('/lang', [LangController::class, 'store']);
// Route::put('/lang/{id}', [LangController::class, 'update']);
// Route::get('/langs', [LangController::class, 'index']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/create-user', [AuthController::class, 'createUser'])->name('create-user');
    Route::get('/users/{id}', [AuthController::class, 'getUserById'])->name('get-User-by-id');
    Route::post('/users/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('/categories', CategoryController::class)->names('categories')->except('create', 'edit');

    Route::resource('/stores', StoreController::class)->names('stores')->except('create', 'edit','update');
    Route::match(['post','put'],'/stores/{store}', [StoreController::class, 'update'])->name('stores.update');

    Route::resource('/coupons', CouponController::class)->names('coupons')->except('create', 'edit');

    Route::resource('/products', ProductController::class)->names('products')->except('create', 'edit','update');
    Route::match(['post','put'],'/products/{product}', [ProductController::class, 'update'])->name('products.update');

});





