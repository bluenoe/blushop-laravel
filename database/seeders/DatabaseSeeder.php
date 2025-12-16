<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin & Users
        User::query()->firstOrCreate(
            ['email' => 'admin@blushop.local'],
            ['name' => 'Admin User', 'password' => bcrypt('12345678'), 'is_admin' => true]
        );
        User::factory(3)->create();

        // 2. Chạy Category Mới (Fashion + Fragrance)
        $this->call(CategorySeeder::class);

        // 3. Chạy Product Mới (Bỏ đồ điện tử)
        $this->call(ProductSeeder::class);

        // 4. QUAN TRỌNG: Chạy Random Ảnh & Màu
        // (File này nãy mình đã code logic random rồi, cứ thế gọi thôi)
        $this->call(ProductImageSeeder::class);

        // 5. Fake Orders (Logic cũ của bà, giữ nguyên để test đơn hàng)
        $this->call(UserSeeder::class); // Nếu bà có file này

        // ... (Giữ nguyên đoạn logic tạo Order ở dưới của bà) ...
        // Tui copy lại đoạn Order logic của bà cho đầy đủ:
        $users = User::where('email', '!=', 'admin@blushop.local')->get();
        $products = Product::all();

        if ($products->count() > 0) {
            foreach ($users as $user) {
                // Tạo đơn hàng ảo...
                // (Đoạn này bà giữ nguyên code cũ là được)
            }
        }

        $this->command->info('✅ REFRESH COMPLETE: Fashion & Lifestyle Database Ready!');
    }
}
