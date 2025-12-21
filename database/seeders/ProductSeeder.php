<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // ==========================================
        // 1. DANH SÁCH NAM (MEN) - 20 SẢN PHẨM
        // ==========================================
        $menProducts = [
            // TOPS (Áo)
            ['name' => 'Men Basic Tee',         'slug' => 'men-basic-tee',          'price' => 250000, 'variants' => ['black', 'white', 'navy', 'red']],
            ['name' => 'Men Polo Shirt',        'slug' => 'men-polo-shirt',         'price' => 350000, 'variants' => ['navy', 'black', 'blue', 'green', 'beige']],
            ['name' => 'Men Oxford Shirt',      'slug' => 'men-oxford-shirt',       'price' => 450000, 'variants' => ['black', 'grey', 'brown']],
            ['name' => 'Men Flannel Shirt',     'slug' => 'men-flannel-shirt',      'price' => 480000, 'variants' => ['blue', 'red', 'white']],
            ['name' => 'Men Graphic T-Shirt',   'slug' => 'men-graphic-tee',        'price' => 320000, 'variants' => ['blue', 'white']],
            ['name' => 'Men Hoodie',            'slug' => 'men-hoodie',             'price' => 550000, 'variants' => ['black', 'brown']],
            ['name' => 'Men Zip Sweater',       'slug' => 'men-zip-sweater',        'price' => 600000, 'variants' => ['beige', 'grey', 'brown']],
            ['name' => 'Men Denim Jacket',      'slug' => 'men-denim-jacket',       'price' => 850000, 'variants' => ['blue', 'brown']],
            ['name' => 'Men Bomber Jacket',     'slug' => 'men-bomber-jacket',      'price' => 950000, 'variants' => ['navy', 'black', 'red', 'white']],
            ['name' => 'Men Puffer Vest',       'slug' => 'men-puffer-vest',        'price' => 700000, 'variants' => ['black', 'brown', 'grey']],

            // BOTTOMS (Quần)
            ['name' => 'Men Chino Shorts',      'slug' => 'men-chino-shorts',       'price' => 350000, 'variants' => ['blue', 'black', 'brown']],
            ['name' => 'Men Denim Shorts',      'slug' => 'men-denim-shorts',       'price' => 380000, 'variants' => ['beige', 'black', 'white']],
            ['name' => 'Men Slim Jeans',        'slug' => 'men-slim-jeans',         'price' => 650000, 'variants' => ['grey', 'black']],
            ['name' => 'Men Cargo Pants',       'slug' => 'men-cargo-pants',        'price' => 550000, 'variants' => ['green', 'beige', 'navy']],
            ['name' => 'Men Chino Trousers',    'slug' => 'men-chino-trousers',     'price' => 500000, 'variants' => ['beige', 'blue', 'brown']],
            ['name' => 'Men Joggers',           'slug' => 'men-joggers',            'price' => 420000, 'variants' => ['green', 'black', 'white']],
            ['name' => 'Men Sweatpants',        'slug' => 'men-sweatpants',         'price' => 400000, 'variants' => ['grey', 'black', 'white']],
            ['name' => 'Men Swim Trunks',       'slug' => 'men-swim-trunks',        'price' => 300000, 'variants' => ['red', 'black', 'navy', 'white']],

            // ACCESSORIES/OTHERS
            ['name' => 'Men Linen Suit',        'slug' => 'men-linen-suit',         'price' => 2500000, 'variants' => ['beige', 'black', 'brown', 'grey']],
            ['name' => 'Men Oversized Tee',     'slug' => 'men-oversized-tee',      'price' => 280000, 'variants' => ['grey', 'brown', 'black']],
        ];

        // ==========================================
        // 2. DANH SÁCH NỮ (WOMEN) - 20 SẢN PHẨM
        // ==========================================
        $womenProducts = [
            // DRESSES & SKIRTS
            ['name' => 'Women Silk Dress',      'slug' => 'women-silk-dress',       'price' => 650000, 'variants' => ['green', 'grey', 'white']],
            ['name' => 'Women Summer Maxi',     'slug' => 'women-summer-maxi',      'price' => 550000, 'variants' => ['black', 'navy', 'red']],
            ['name' => 'Women Bodycon Dress',   'slug' => 'women-bodycon-dress',    'price' => 450000, 'variants' => ['black', 'brown', 'grey']],
            ['name' => 'Women Pleated Skirt',   'slug' => 'women-pleated-skirt',    'price' => 320000, 'variants' => ['beige', 'black']],
            ['name' => 'Women Mini Skirt',      'slug' => 'women-mini-skirt',       'price' => 280000, 'variants' => ['red', 'black', 'white']],
            ['name' => 'Women Denim Skirt',     'slug' => 'women-denim-skirt',      'price' => 350000, 'variants' => ['beige', 'brown']],

            // TOPS
            ['name' => 'Women Crop Top',        'slug' => 'women-crop-top',         'price' => 150000, 'variants' => ['beige', 'navy']],
            ['name' => 'Women Silk Blouse',     'slug' => 'women-silk-blouse',      'price' => 420000, 'variants' => ['grey', 'red']],
            ['name' => 'Women Oversized Tee',   'slug' => 'women-oversized-tee',    'price' => 250000, 'variants' => ['white', 'green']],
            ['name' => 'Women Knit Cardigan',   'slug' => 'women-knit-cardigan',    'price' => 480000, 'variants' => ['black', 'grey']],
            ['name' => 'Women Turtle Neck',     'slug' => 'women-turtle-neck',      'price' => 320000, 'variants' => ['white', 'navy']],
            ['name' => 'Women Blazer',          'slug' => 'women-blazer',           'price' => 750000, 'variants' => ['black', 'white']],
            ['name' => 'Women Leather Jacket',  'slug' => 'women-leather-jacket',   'price' => 1200000, 'variants' => ['black', 'brown']],
            ['name' => 'Women Trench Coat',     'slug' => 'women-trench-coat',      'price' => 1500000, 'variants' => ['brown', 'navy']],

            // BOTTOMS
            ['name' => 'Women Mom Jeans',       'slug' => 'women-mom-jeans',        'price' => 550000, 'variants' => ['white', 'black']],
            ['name' => 'Women Skinny Jeans',    'slug' => 'women-skinny-jeans',     'price' => 520000, 'variants' => ['black', 'brown']],
            ['name' => 'Women Wide Leg Pants',  'slug' => 'women-wide-leg-pants',   'price' => 480000, 'variants' => ['brown', 'black', 'red']],
            ['name' => 'Women Biker Shorts',    'slug' => 'women-biker-shorts',     'price' => 200000, 'variants' => ['grey', 'white']],
            ['name' => 'Women Linen Shorts',    'slug' => 'women-linen-shorts',     'price' => 280000, 'variants' => ['white']],
            ['name' => 'Women Yoga Leggings',   'slug' => 'women-yoga-leggings',    'price' => 350000, 'variants' => ['grey']],
        ];

        // CHẠY HÀM TẠO
        $this->seedCategory($menProducts, 'men');
        $this->seedCategory($womenProducts, 'women');
    }

    private function seedCategory($products, $category)
    {
        foreach ($products as $item) {
            // [LOGIC MỚI] Lấy màu đầu tiên làm ảnh đại diện
            // Ví dụ: ['black', 'white'] -> Lấy 'black' -> Tạo thành 'black.jpg'
            $firstVariant = $item['variants'][0] ?? 'default';
            $mainImage = "{$firstVariant}.jpg";

            $productId = DB::table('products')->insertGetId([
                'name' => $item['name'],
                'slug' => $item['slug'],
                'description' => "This is a premium {$item['name']} for {$category}.",
                'category' => $category,
                'base_price' => $item['price'],
                'image' => $mainImage, // <--- Cột này đã được tự động điền
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($item['variants'] as $color) {
                DB::table('product_variants')->insert([
                    'product_id' => $productId,
                    'sku' => strtoupper($item['slug']) . '-' . strtoupper($color),
                    'color_name' => ucfirst($color),
                    'color_hex' => $this->getColorHex($color),
                    'price' => $item['price'],
                    'stock' => rand(10, 100),
                    'image_path' => "products/{$item['slug']}/{$color}.jpg",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function getColorHex($colorName)
    {
        $map = [
            'black' => '#000000',
            'white' => '#FFFFFF',
            'navy' => '#000080',
            'blue' => '#0000FF',
            'beige' => '#F5F5DC',
            'grey' => '#808080',
            'red' => '#FF0000',
            'pink' => '#FFC0CB',
            'cream' => '#FFFDD0',
            'green' => '#008000',
            'yellow' => '#FFFF00',
            'brown' => '#A52A2A',
            'purple' => '#800080',
            'khaki' => '#F0E68C',
            'plaid' => '#333333',
            'floral' => '#FF69B4'
        ];
        return $map[$colorName] ?? '#CCCCCC';
    }
}