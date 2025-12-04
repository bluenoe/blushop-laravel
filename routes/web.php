<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| - Public: landing, product, cart, contact, static pages
| - User (auth): wishlist, checkout, orders, profile
| - Admin: dashboard + CRUD
*/

/**
 * Public routes
 */
// Landing page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Shop home page
Route::view('/home', 'home')->name('home');

// Products listing + detail
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// (Optional) legacy URL /product/{id} -> same action
Route::get('/product/{id}', [ProductController::class, 'show'])
    ->whereNumber('id')
    ->name('product.show');

// Cart (session-based)
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{id}', [CartController::class, 'add'])->whereNumber('id')->name('cart.add');
    Route::post('/update/{id}', [CartController::class, 'update'])->whereNumber('id')->name('cart.update');
    Route::post('/remove/{id}', [CartController::class, 'remove'])->whereNumber('id')->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// Contact
Route::get('/contact', [ContactController::class, 'show'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Static pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/faq', 'pages.faq')->name('faq');

/**
 * Breeze auth routes (login/register/logout)
 */
require __DIR__ . '/auth.php';

/**
 * Authenticated user routes
 */
Route::middleware('auth')->group(function () {
    // Wishlist (DB-backed)
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place', [CheckoutController::class, 'place'])->name('checkout.place');

    // User orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Profile wishlist shortcut
    Route::get('/profile/wishlist', [WishlistController::class, 'index'])->name('profile.wishlist');
});

/**
 * Backwards-compatible alias for older components expecting 'dashboard'
 */
Route::redirect('/dashboard', '/admin/dashboard')->name('dashboard');

/**
 * Admin routes (auth + is_admin)
 */
Route::prefix('admin')
    ->middleware(['auth', 'is_admin'])
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Products CRUD
        Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
        Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products', [AdminProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

        // Categories CRUD
        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');

        // Users CRUD (optional)
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

        // Orders management
        Route::prefix('orders')->group(function () {
            Route::get('/', [AdminOrderController::class, 'index'])->name('admin.orders.index');
            Route::get('/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
            Route::post('/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.status');
        });
    });

// Backward-compatible root /admin redirect to /admin/dashboard
Route::redirect('/admin', '/admin/dashboard');
