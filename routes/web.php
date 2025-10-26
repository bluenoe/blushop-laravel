<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes (Day 2)
|--------------------------------------------------------------------------
| Update: Trang chủ gọi ProductController@index để render products grid.
| Các route khác giữ placeholder 501 như Day 1 (sẽ làm ở Day 3-5).
*/

Route::get('/', [ProductController::class, 'index'])->name('home');

/**
 * Product detail (Day 3 sẽ implement)
 */
Route::get('/product/{id}', function (int $id) {
    return response("Product detail placeholder for ID: {$id}", 501);
})->whereNumber('id')->name('product.show');

/**
 * Cart (Day 3)
 */
Route::get('/cart', function () {
    return response('Cart page placeholder', 501);
})->name('cart.index');

/**
 * Checkout (Day 4)
 */
Route::get('/checkout', function () {
    return response('Checkout page placeholder (will require auth at Day 4)', 501);
})->name('checkout.index');

/**
 * Contact (Day 5)
 */
Route::get('/contact', function () {
    return response('Contact form placeholder', 501);
})->name('contact.index');
