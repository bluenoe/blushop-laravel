<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => ucfirst(fake()->words(2, true)),
            'description' => fake()->paragraph(2),
            'price' => fake()->randomFloat(2, 5, 199),
            'image' => null,
            // category_id will be set in seeder/controller; keep null here
            'category_id' => null,
        ];
    }
}
