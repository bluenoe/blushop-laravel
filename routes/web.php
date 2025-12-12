<?php

use Illuminate\Support\Facades\Route;

// --- Controllers (Tổng hợp từ cả 2 file) ---
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
*/

// --- PUBLIC ROUTES (Landing & Static Pages) ---

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Home Page (Alternative Home)
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Contact & Pages
Route::get('/contact', [ContactController::class, 'show'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::view('/about', 'pages.about')->name('about');
Route::view('/faq', 'pages.faq')->name('faq');


// --- PRODUCT ROUTES ---

// Listing & Filters (Giữ lại từ file trên)
Route::get('/new-arrivals', [ProductController::class, 'newArrivals'])->name('new-arrivals');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Product Detail (Lấy logic XỊN từ file dưới - dùng Slug)
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
// Fallback cho link cũ dùng ID nếu cần (Optional)
Route::get('/product/{id}', [ProductController::class, 'show'])->whereNumber('id');


// --- CART ROUTES (Lấy logic XỊN từ file dưới) ---
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    // Giữ lại route clear từ file trên nhưng đưa vào group này cho tiện
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});


// --- WISHLIST ROUTES (Lấy logic XỊN từ file dưới) ---
Route::prefix('wishlist')->name('wishlist.')->group(function () {
    // Public routes (AJAX toggle thường không cần Auth cứng ở route mà check trong controller hoặc FE xử lý)
    Route::post('/toggle', [WishlistController::class, 'toggle'])->name('toggle');

    // Authenticated routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::delete('/remove/{id}', [WishlistController::class, 'remove'])->name('remove');
        Route::delete('/clear', [WishlistController::class, 'clear'])->name('clear');
        Route::post('/move-to-cart', [WishlistController::class, 'moveToCart'])->name('moveToCart');
    });
});


// --- REVIEW ROUTES (Lấy logic XỊN từ file dưới) ---
Route::middleware(['auth'])->prefix('reviews')->name('reviews.')->group(function () {
    Route::post('/products/{product}', [ReviewController::class, 'store'])->name('store');
    Route::patch('/{review}', [ReviewController::class, 'update'])->name('update');
    Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('destroy');
    Route::post('/{review}/helpful', [ReviewController::class, 'markHelpful'])->name('helpful');
});


// --- AUTH ROUTES (Breeze) ---
require __DIR__ . '/auth.php';


// --- AUTHENTICATED USER ROUTES (Checkout, Orders, Profile) ---
Route::middleware('auth')->group(function () {

    // Checkout (Giữ lại từ file trên)
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place', [CheckoutController::class, 'place'])->name('checkout.place');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Orders (Giữ lại từ file trên)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Profile (Giữ lại từ file trên)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// --- ADMIN ROUTES (Giữ nguyên từ file trên) ---
Route::prefix('admin')
    ->middleware(['auth', 'is_admin'])
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::redirect('/', '/admin/dashboard');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Products
        Route::resource('products', AdminProductController::class);

        // Categories
        Route::resource('categories', AdminCategoryController::class);

        // Users
        Route::resource('users', AdminUserController::class)->except(['create', 'store']);

        // Orders
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [AdminOrderController::class, 'index'])->name('index');
            Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
            Route::post('/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('status');
        });

        // Settings
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });


// --- FALLBACK & REDIRECTS ---
Route::get('/dashboard', function () {
    return auth()->user()->is_admin ? redirect()->route('admin.dashboard') : redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
