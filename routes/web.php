<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\LandingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;

// Admin Controllers
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| - Public: Landing, Product, Cart, Contact, Static Pages
| - Auth: Checkout, Wishlist, Profile, Orders
| - Admin: Dashboard + CRUD
*/

// --- PUBLIC ROUTES ---

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');


// Home Page (Alternative Home)
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Products
Route::get('/new-arrivals', [ProductController::class, 'newArrivals'])->name('new-arrivals');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/product/{id}', [ProductController::class, 'show'])->whereNumber('id');

// Cart (Session-based, AJAX Compatible)
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{id}', [CartController::class, 'add'])->whereNumber('id')->name('cart.add');
    Route::match(['post', 'patch'], '/update', [CartController::class, 'update'])->name('cart.update');
    Route::match(['post', 'delete'], '/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// Contact & Pages
Route::get('/contact', [ContactController::class, 'show'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::view('/about', 'pages.about')->name('about');
Route::view('/faq', 'pages.faq')->name('faq');

// Reviews
Route::post('/products/{id}/reviews', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('reviews.store');


// --- AUTH ROUTES (Breeze) ---
require __DIR__ . '/auth.php';


// --- AUTHENTICATED USER ROUTES ---
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place', [CheckoutController::class, 'place'])->name('checkout.place');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile/wishlist', [WishlistController::class, 'index']);
});


// --- ADMIN ROUTES ---
Route::prefix('admin')
    ->middleware(['auth', 'is_admin'])
    ->name('admin.') // [TUI KIỂM TRA]: name('admin.') này cực kỳ quan trọng để các link sidebar hoạt động
    ->group(function () {

        // Dashboard
        Route::redirect('/', '/admin/dashboard');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Products
        Route::resource('products', AdminProductController::class);

        // Categories
        Route::resource('categories', AdminCategoryController::class);

        // Users
        // [TUI KIỂM TRA]: Phải giữ logic nãy để xem được profile khách hàng nhé
        Route::resource('users', AdminUserController::class)->except(['create', 'store']);

        // Orders
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [AdminOrderController::class, 'index'])->name('index');
            Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
            Route::post('/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('status');
        });

        // [TUI SỬA]: Viết lại đoạn settings dùng Alias AdminSettingController cho đồng bộ và sạch đẹp
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });

Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');


// Fallback
Route::get('/dashboard', function () {
    return auth()->user()->is_admin ? redirect()->route('admin.dashboard') : redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

/* Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
 */