<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Http\Responses\LoginResponse;
use App\Listeners\SendOrderEmail;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use \App\Models\Setting;
use \App\Models\Category;
use Illuminate\Support\Facades\View;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind Fortify's login response to our custom implementation
        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Event Listeners
        Event::listen(OrderPlaced::class, SendOrderEmail::class);

        // --- ĐOẠN FIX LỖI NGROK ---
        // Lấy URL hiện tại trong file .env
        $appUrl = Config::get('app.url');

        // Nếu trong .env có chữ 'ngrok' (tức là bà đang điền link ngrok vào đó)
        if (str_contains($appUrl, 'ngrok')) {
            // Ép Laravel dùng chính cái link đó làm gốc (Gỡ bỏ cái blushop.test đi)
            URL::forceRootUrl($appUrl);
            // Ép dùng HTTPS
            URL::forceScheme('https');
        }
        // ---------------------------

        // Fix lỗi độ dài key string cho một số DB cũ
        Schema::defaultStringLength(191);

        // CHIA SẺ DỮ LIỆU CHO TOÀN BỘ VIEW
        if (!app()->runningInConsole()) {
            $globalSettings = cache()->remember('global_settings', 3600, function () {
                try {
                    return Setting::all()->pluck('value', 'key')->toArray();
                } catch (\Exception $e) {
                    return [];
                }
            });

            $globalCategories = cache()->remember('global_categories', 3600, function () {
                try {
                    return Category::withCount('products')->get();
                } catch (\Exception $e) {
                    return [];
                }
            });

            View::share('settings', $globalSettings);
            View::share('categories', $globalCategories);
        }
    }
}
