<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $samples = [
            ['name' => 'Teddy Classic', 'price_vnd' => 120000, 'image' => 'products/sample1.jpg'],
            ['name' => 'Teddy Big',     'price_vnd' => 220000, 'image' => 'products/sample2.jpg'],
            ['name' => 'Teddy Pink',    'price_vnd' => 180000, 'image' => 'products/sample3.jpg'],
            ['name' => 'Teddy Blue',    'price_vnd' => 150000, 'image' => 'products/sample1.jpg'],
            ['name' => 'Teddy Brown',   'price_vnd' => 200000, 'image' => 'products/sample2.jpg'],
            ['name' => 'Teddy Mini',    'price_vnd' =>  90000, 'image' => 'products/sample3.jpg'],
            ['name' => 'Teddy Hoodie',  'price_vnd' => 250000, 'image' => 'products/sample1.jpg'],
            ['name' => 'Teddy VIP',     'price_vnd' => 350000, 'image' => 'products/sample2.jpg'],
        ];

        foreach ($samples as $s) {
            Product::create([
                'name' => $s['name'],
                'description' => null,
                'price' => $s['price_vnd'],      // giữ để backward-compat, không dùng để tính
                'price_vnd' => $s['price_vnd'],  // nguồn tính tiền chính
                'image' => $s['image'],
            ]);
        }
    }
}
