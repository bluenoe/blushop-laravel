<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes (Day 4)
|--------------------------------------------------------------------------
| - Trang chủ: ProductController@index
| - Chi tiết: ProductController@show
| - Cart CRUD: session-based
| - Checkout: auth-only (Breeze)
| - Contact: placeholder (Day 5)
*/

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard'); // nhớ có file view
})->middleware(['auth'])->name('dashboard'); // bỏ 'verified' nếu chưa bật email verify


Route::get('/product/{id}', [ProductController::class, 'show'])
    ->whereNumber('id')
    ->name('product.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->whereNumber('id')->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->whereNumber('id')->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->whereNumber('id')->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

/**
 * Checkout (auth-only)
 */
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place', [CheckoutController::class, 'place'])->name('checkout.place');
});

/**
 * Contact (Day 5)
 */
Route::get('/contact', function () {
    return response('Contact form placeholder', 501);
})->name('contact.index');

/**
 * Breeze auth routes
 * (được tạo bởi php artisan breeze:install)
 */
require __DIR__.'/auth.php';
