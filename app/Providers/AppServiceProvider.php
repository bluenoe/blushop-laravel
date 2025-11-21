<?php

namespace App\Providers;

use App\Http\Responses\LoginResponse;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
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
        // Console-only auto seeding of admin account
        if (app()->runningInConsole()) {
            try {
                if (Schema::hasTable('users')) {
                    $existing = User::query()->where('email', 'admin@blushop.local')->first();
                    if (! $existing) {
                        User::query()->create([
                            'name' => 'Admin User',
                            'email' => 'admin@blushop.local',
                            'password' => bcrypt('12345678'),
                            'is_admin' => true,
                        ]);
                        $this->app['log']->info('✔ Admin account ready!');
                    }
                }
            } catch (\Throwable $e) {
                // Silently ignore during migrations when table may not exist
            }
        }
    }
}
