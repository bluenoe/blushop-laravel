<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->truncate();
        $now = Carbon::now();

        // Helper lấy ID category
        $getCat = function ($slug) {
            return DB::table('categories')->where('slug', $slug)->value('id');
        };

        $items = [
            // ================= MEN =================
            ['name' => 'Essential Tee - Black',      'price' => 199000, 'cat' => $getCat('men-tops')],
            ['name' => 'Essential Tee - White',      'price' => 199000, 'cat' => $getCat('men-tops')],
            ['name' => 'Heavy Cotton Oversized Tee', 'price' => 249000, 'cat' => $getCat('men-tops')],
            ['name' => 'Everyday Hoodie',            'price' => 399000, 'cat' => $getCat('men-outerwear')],
            ['name' => 'MA-1 Bomber Jacket',         'price' => 599000, 'cat' => $getCat('men-outerwear')],
            ['name' => 'Utility Cargo Pants',        'price' => 459000, 'cat' => $getCat('men-bottoms')],
            ['name' => 'Slim Fit Chinos',            'price' => 399000, 'cat' => $getCat('men-bottoms')],
            ['name' => 'Varsity Jacket',             'price' => 699000, 'cat' => $getCat('men-outerwear')],
            ['name' => 'Performance Active Tee',     'price' => 229000, 'cat' => $getCat('men-activewear')],
            ['name' => 'Running Shorts',             'price' => 259000, 'cat' => $getCat('men-activewear')],

            // ================= WOMEN =================
            ['name' => 'Silk Camisole',              'price' => 229000, 'cat' => $getCat('women-tops')],
            ['name' => 'Flowy Maxi Dress',           'price' => 459000, 'cat' => $getCat('women-dresses')],
            ['name' => 'Floral Midi Dress',          'price' => 499000, 'cat' => $getCat('women-dresses')],
            ['name' => 'Cocktail Mini Dress',        'price' => 399000, 'cat' => $getCat('women-dresses')],
            ['name' => 'Pleated Midi Skirt',         'price' => 359000, 'cat' => $getCat('women-bottoms')],
            ['name' => 'High-Waisted Mom Jeans',     'price' => 459000, 'cat' => $getCat('women-bottoms')],
            ['name' => 'Classic Trench Coat',        'price' => 899000, 'cat' => $getCat('women-outerwear')],
            ['name' => 'Cropped Puffer',             'price' => 599000, 'cat' => $getCat('women-outerwear')],
            ['name' => 'Oversized Blazer',           'price' => 699000, 'cat' => $getCat('women-outerwear')],

            // ================= FRAGRANCE (MỚI) =================
            ['name' => 'Santal 33 - Le Labo',        'price' => 4500000, 'cat' => $getCat('fragrance-unisex')],
            ['name' => 'Bleu de Chanel',             'price' => 3200000, 'cat' => $getCat('fragrance-for-him')],
            ['name' => 'Dior Sauvage Elixir',        'price' => 3800000, 'cat' => $getCat('fragrance-for-him')],
            ['name' => 'YSL Libre',                  'price' => 2900000, 'cat' => $getCat('fragrance-for-her')],
            ['name' => 'Miss Dior Blooming',         'price' => 2800000, 'cat' => $getCat('fragrance-for-her')],
            ['name' => 'Tom Ford Tobacco Vanille',   'price' => 6500000, 'cat' => $getCat('fragrance-unisex')],
        ];

        // Chuẩn bị dữ liệu insert
        $data = [];
        foreach ($items as $item) {
            // Logic Image: Tạm thời để null hoặc placeholder vì bà sẽ chạy ProductImageSeeder sau
            // Nhưng để bảng products không bị lỗi, ta fake đại tên ảnh
            $fakeImg = Str::slug($item['name']) . '.jpg';

            $data[] = [
                'name'          => $item['name'],
                'slug'          => Str::slug($item['name']),
                'description'   => "Designed for modern living. Minimalist aesthetic typical of BluShop.",
                'price'         => $item['price'],
                'image'         => $fakeImg, // Ảnh thumbnail tạm
                'category_id'   => $item['cat'],
                'type'          => str_contains($item['name'], 'Dior') || str_contains($item['name'], 'Santal') ? 'fragrance' : 'apparel',
                'is_new'        => rand(0, 1) > 0.6,
                'is_bestseller' => rand(0, 1) > 0.7,
                'is_on_sale'    => rand(0, 1) > 0.8,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        DB::table('products')->insert($data);
    }
}
