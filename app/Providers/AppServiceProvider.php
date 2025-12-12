<?php

namespace App\Providers;

use App\Http\Responses\LoginResponse;
use App\Models\User;
use Illuminate\Support\Facades\URL;
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

        if ($this->app->environment('production') || $this->app->environment('local')) {
            URL::forceScheme('https');
        }

        // Fix lỗi độ dài key string cho một số DB cũ
        Schema::defaultStringLength(191);

        // CHIA SẺ DỮ LIỆU CHO TOÀN BỘ VIEW
        // Chỉ chạy khi không phải trong console (để tránh lỗi khi chạy migrate)
        if (!app()->runningInConsole()) {

            // 1. Chia sẻ Global Settings (Lấy về dạng mảng key => value)
            // Cache lại 60 phút để đỡ tốn query database mỗi lần load trang
            $globalSettings = cache()->remember('global_settings', 3600, function () {
                // Nếu bảng settings chưa có (lúc mới migrate), trả về mảng rỗng
                try {
                    return Setting::all()->pluck('value', 'key')->toArray();
                } catch (\Exception $e) {
                    return [];
                }
            });

            // 2. Chia sẻ Categories cho Menu
            $globalCategories = cache()->remember('global_categories', 3600, function () {
                try {
                    return Category::withCount('products')->get();
                } catch (\Exception $e) {
                    return [];
                }
            });

            // Share biến $settings và $categories ra toàn bộ view
            View::share('settings', $globalSettings);
            View::share('categories', $globalCategories);
        }
    }
}
