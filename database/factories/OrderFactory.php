<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'total_amount' => 0,
            'payment_status' => fake()->randomElement(['pending', 'paid', 'cancelled']),
            'shipping_address' => fake()->address(),
        ];
    }
}
