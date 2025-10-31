<?php

namespace Database\Seeders;

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

        // 3) Sample products
        $products = Product::factory(10)->create();

        // 4) Fake orders per user (3 each)
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
        $this->command?->info('Seeded orders: '.(Order::query()->count()));
        $this->command?->info('Seeded order items: '.(OrderItem::query()->count()));
    }
}
