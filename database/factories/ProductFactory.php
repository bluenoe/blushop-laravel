<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = ucfirst(fake()->words(3, true));
        
        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(4),
            'sku' => strtoupper(fake()->unique()->bothify('???-####')), // Generates ABC-1234
            'description' => fake()->paragraph(2),
            'base_price' => fake()->numberBetween(100000, 2000000), // VND range
            'stock' => fake()->numberBetween(0, 100),
            'image' => null,
            'category' => fake()->randomElement(['men', 'women', 'fragrance']),
            'is_active' => true,
            'is_new' => fake()->boolean(30),
            'is_bestseller' => fake()->boolean(20),
            'is_on_sale' => fake()->boolean(15),
        ];
    }
}

