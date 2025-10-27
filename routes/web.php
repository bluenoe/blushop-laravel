<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes (Day 5)
|--------------------------------------------------------------------------
| - Trang chủ: ProductController@index
| - Chi tiết: ProductController@show
| - Cart CRUD: session-based
| - Checkout: auth-only (Breeze)
| - Contact: form + lưu DB
*/

// Landing page
Route::get('/', [LandingController::class, 'index'])->name('home');

// Products listing (target of "Shop Now" button)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/product/{id}', [ProductController::class, 'show'])
    ->whereNumber('id')
    ->name('product.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->whereNumber('id')->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->whereNumber('id')->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->whereNumber('id')->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place', [CheckoutController::class, 'place'])->name('checkout.place');
});

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

/**
 * Breeze auth routes (login/register/logout)
 */
require __DIR__.'/auth.php';
