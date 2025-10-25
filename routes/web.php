<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Day 1)
|--------------------------------------------------------------------------
| Skeleton routes. Chưa gắn controller để tránh dead code.
| Dùng closure placeholder (HTTP 501) cho các trang chưa làm.
*/

Route::get('/', function () {
    return view('home');
})->name('home');

/**
 * Product detail (chưa có controller Day 1)
 * Day 3 sẽ gắn ProductController@show
 */
Route::get('/product/{id}', function (int $id) {
    return response("Product detail placeholder for ID: {$id}", 501);
})->whereNumber('id')->name('product.show');

/**
 * Cart (chưa có controller Day 1)
 * Day 3 sẽ gắn CartController
 */
Route::get('/cart', function () {
    return response('Cart page placeholder', 501);
})->name('cart.index');

/**
 * Checkout (auth-only ở Day 4 — hiện chỉ placeholder)
 */
Route::get('/checkout', function () {
    return response('Checkout page placeholder (will require auth at Day 4)', 501);
})->name('checkout.index');

/**
 * Contact (Day 5 sẽ làm form + lưu DB)
 */
Route::get('/contact', function () {
    return response('Contact form placeholder', 501);
})->name('contact.index');

