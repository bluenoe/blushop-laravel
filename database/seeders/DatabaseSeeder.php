<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1) Admin account (idempotent)
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

        // 3) Categories (seed demo + ensure Uncategorized exists)
        $this->call(CategorySeeder::class);

        $uncat = Category::query()->firstOrCreate(
            ['slug' => 'uncategorized'],
            ['name' => 'Uncategorized', 'description' => 'Default catch-all category']
        );

        // 4) Products: dùng ProductSeeder của Blu (18 sản phẩm BluShop)
        $this->call(ProductSeeder::class);

        // Lấy toàn bộ sản phẩm sau khi seed
        $products = Product::all();

        // Gán category hợp lý dựa vào tên, nếu không match thì gán Uncategorized
        $cats = Category::query()->pluck('id', 'slug');

        foreach ($products as $product) {
            $name = strtolower($product->name);
            $categoryId = null;

            if (str_contains($name, 'hoodie')) {
                $categoryId = $cats['hoodies'] ?? null;
            } elseif (str_contains($name, 'shirt') || str_contains($name, 't-shirt')) {
                $categoryId = $cats['t-shirts'] ?? null;
            } elseif (str_contains($name, 'mug')) {
                $categoryId = $cats['mugs'] ?? null;
            } elseif (str_contains($name, 'sticker')) {
                $categoryId = $cats['stickers'] ?? null;
            } elseif (str_contains($name, 'cap')) {
                $categoryId = $cats['caps'] ?? null;
            } elseif (str_contains($name, 'bag')) {
                $categoryId = $cats['bags'] ?? null;
            } elseif (str_contains($name, 'note') || str_contains($name, 'book')) {
                $categoryId = $cats['stationery'] ?? null;
            }

            $product->category_id = $categoryId ?? $uncat->id;
            $product->save();
        }

        // 5) Fake orders per user (3 each)
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

        // Console summary output
        $this->command?->info('✔ Admin account ready!');
        $this->command?->info('Seeded users: '.(User::query()->count()));
        $this->command?->info('Seeded products: '.(Product::query()->count()));
        $this->command?->info('Seeded categories: '.(Category::query()->count()));
        $this->command?->info('Seeded orders: '.(Order::query()->count()));
        $this->command?->info('Seeded order items: '.(OrderItem::query()->count()));
    }
}
