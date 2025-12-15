<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1) Admin account
        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@blushop.local'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('12345678'),
                'is_admin' => true,
            ]
        );

        // 2) Example users
        $users = User::factory(3)->create();

        // 3) Categories (Chạy trước để có ID cho Product dùng)
        // Lưu ý: CategorySeeder đã tự xử lý logic tạo cha/con
        $this->call(CategorySeeder::class);

        // 4) Products (Chạy sau, sử dụng ID từ Category đã tạo)

        $this->call(ProductSeeder::class);

        $this->call(UserSeeder::class);
        // 5) Fake orders per user (3 each) - Để test tính năng Order
        $products = Product::all();

        if ($products->count() > 0) {
            foreach ($users as $user) {
                for ($i = 0; $i < 3; $i++) {
                    $order = Order::factory()->create([
                        'user_id' => $user->id,
                        'payment_status' => 'paid',
                    ]);

                    $itemCount = random_int(1, 4);
                    $total = 0;

                    for ($j = 0; $j < $itemCount; $j++) {
                        $product = $products->random();
                        $qty = random_int(1, 3);
                        $price = (float) $product->price;

                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'quantity' => $qty,
                            'price_at_purchase' => $price,
                        ]);

                        $total += $price * $qty;
                    }

                    $order->update(['total_amount' => $total]);
                }
            }
        }

        // Console summary output
        $this->command?->info('--------------------------------------');
        $this->command?->info('✔ Admin account ready: admin@blushop.local / 12345678');
        $this->command?->info('✔ Seeded users: ' . (User::query()->count()));
        $this->command?->info('✔ Seeded categories: ' . (Category::query()->count()));
        $this->command?->info('✔ Seeded products: ' . (Product::query()->count()));
        $this->command?->info('✔ Seeded orders: ' . (Order::query()->count()));
        $this->command?->info('--------------------------------------');
    }
}
