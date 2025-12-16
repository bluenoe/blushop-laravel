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
        // --- BIỆN PHÁP MẠNH ---
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('products')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // -----------------------

        $now = Carbon::now();
        // ... (Giữ nguyên phần code mảng $items và logic insert bên dưới của bà) ...
        // (Nếu bà cần tui gửi lại full file này thì bảo nhé, nhưng chỉ cần thay đoạn đầu là được)

        // Helper lấy ID category (Copy lại cho chắc)
        $getCat = function ($slug) {
            return DB::table('categories')->where('slug', $slug)->value('id');
        };

        $items = [
            // ==========================================
            // 👔 MEN COLLECTION (Core)
            // ==========================================
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

            // --- 🆕 10 NEW MEN ITEMS (Minimalist Style) ---
            ['name' => 'Stone Wash Denim Jacket',    'price' => 650000, 'cat' => $getCat('men-outerwear')],
            ['name' => 'Relaxed Pleated Trouser',    'price' => 480000, 'cat' => $getCat('men-bottoms')],
            ['name' => 'Heavyweight Mock Neck',      'price' => 320000, 'cat' => $getCat('men-tops')],
            ['name' => 'Technical Cargo Short',      'price' => 290000, 'cat' => $getCat('men-bottoms')],
            ['name' => 'Merino Wool Polo',           'price' => 450000, 'cat' => $getCat('men-tops')],
            ['name' => 'Canvas Chore Coat',          'price' => 590000, 'cat' => $getCat('men-outerwear')],
            ['name' => 'Drop Shoulder Sweatshirt',   'price' => 360000, 'cat' => $getCat('men-tops')],
            ['name' => 'Seersucker Camp Shirt',      'price' => 310000, 'cat' => $getCat('men-tops')],
            ['name' => 'Nylon Ripstop Vest',         'price' => 420000, 'cat' => $getCat('men-outerwear')],
            ['name' => 'Textured Knit Sweater',      'price' => 520000, 'cat' => $getCat('men-tops')],


            // ==========================================
            // 👗 WOMEN COLLECTION (Core)
            // ==========================================
            ['name' => 'Silk Camisole',              'price' => 229000, 'cat' => $getCat('women-tops')],
            ['name' => 'Flowy Maxi Dress',           'price' => 459000, 'cat' => $getCat('women-dresses')],
            ['name' => 'Floral Midi Dress',          'price' => 499000, 'cat' => $getCat('women-dresses')],
            ['name' => 'Cocktail Mini Dress',        'price' => 399000, 'cat' => $getCat('women-dresses')],
            ['name' => 'Pleated Midi Skirt',         'price' => 359000, 'cat' => $getCat('women-bottoms')],
            ['name' => 'High-Waisted Mom Jeans',     'price' => 459000, 'cat' => $getCat('women-bottoms')],
            ['name' => 'Classic Trench Coat',        'price' => 899000, 'cat' => $getCat('women-outerwear')],
            ['name' => 'Cropped Puffer',             'price' => 599000, 'cat' => $getCat('women-outerwear')],
            ['name' => 'Oversized Blazer',           'price' => 699000, 'cat' => $getCat('women-outerwear')],

            // --- 🆕 10 NEW WOMEN ITEMS (Chic Style) ---
            ['name' => 'Satin Midi Skirt',           'price' => 380000, 'cat' => $getCat('women-bottoms')],
            ['name' => 'Ribbed Knit Dress',          'price' => 420000, 'cat' => $getCat('women-dresses')],
            ['name' => 'Oversized Poplin Shirt',     'price' => 350000, 'cat' => $getCat('women-tops')],
            ['name' => 'High-Rise Wide Leg Pant',    'price' => 490000, 'cat' => $getCat('women-bottoms')],
            ['name' => 'Cropped Tweed Jacket',       'price' => 750000, 'cat' => $getCat('women-outerwear')],
            ['name' => 'Cashmere Crewneck',          'price' => 890000, 'cat' => $getCat('women-tops')],
            ['name' => 'Linen Wrap Blazer',          'price' => 620000, 'cat' => $getCat('women-outerwear')],
            ['name' => 'Asymmetric Hem Top',         'price' => 280000, 'cat' => $getCat('women-tops')],
            ['name' => 'Structured Wool Coat',       'price' => 1200000, 'cat' => $getCat('women-outerwear')],
            ['name' => 'Pleated Tennis Skort',       'price' => 250000, 'cat' => $getCat('women-bottoms')],


            // ==========================================
            // 🧴 FRAGRANCE (Lifestyle)
            // ==========================================
            ['name' => 'Santal 33 - Le Labo',        'price' => 4500000, 'cat' => $getCat('fragrance-unisex')],
            ['name' => 'Bleu de Chanel',             'price' => 3200000, 'cat' => $getCat('fragrance-for-him')],
            ['name' => 'Dior Sauvage Elixir',        'price' => 3800000, 'cat' => $getCat('fragrance-for-him')],
            ['name' => 'YSL Libre',                  'price' => 2900000, 'cat' => $getCat('fragrance-for-her')],
            ['name' => 'Miss Dior Blooming',         'price' => 2800000, 'cat' => $getCat('fragrance-for-her')],
            ['name' => 'Tom Ford Tobacco Vanille',   'price' => 6500000, 'cat' => $getCat('fragrance-unisex')],
        ];

        $data = [];
        foreach ($items as $item) {
            $fakeImg = Str::slug($item['name']) . '.jpg';
            $data[] = [
                'name'          => $item['name'],
                'slug'          => Str::slug($item['name']),
                'description'   => "Designed for modern living. Minimalist aesthetic typical of BluShop.",
                'price'         => $item['price'],
                'image'         => $fakeImg,
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
