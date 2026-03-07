<?php

namespace Database\Seeders;

use App\Models\Category;
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
            ['name' => 'Men Basic Tee',         'slug' => 'men-basic-tee',          'price' => 250000, 'variants' => ['black', 'white', 'navy', 'red'],       'child' => 'men-tops'],
            ['name' => 'Men Polo Shirt',        'slug' => 'men-polo-shirt',         'price' => 350000, 'variants' => ['navy', 'black', 'blue', 'green', 'beige'], 'child' => 'men-tops'],
            ['name' => 'Men Oxford Shirt',      'slug' => 'men-oxford-shirt',       'price' => 450000, 'variants' => ['black', 'grey', 'brown'],              'child' => 'men-tops'],
            ['name' => 'Men Flannel Shirt',     'slug' => 'men-flannel-shirt',      'price' => 480000, 'variants' => ['blue', 'red', 'white'],                'child' => 'men-tops'],
            ['name' => 'Men Graphic T-Shirt',   'slug' => 'men-graphic-tee',        'price' => 320000, 'variants' => ['blue', 'white'],                       'child' => 'men-tops'],

            // OUTERWEAR
            ['name' => 'Men Hoodie',            'slug' => 'men-hoodie',             'price' => 550000, 'variants' => ['black', 'brown'],                      'child' => 'men-outerwear'],
            ['name' => 'Men Zip Sweater',       'slug' => 'men-zip-sweater',        'price' => 600000, 'variants' => ['beige', 'grey', 'brown'],              'child' => 'men-outerwear'],
            ['name' => 'Men Denim Jacket',      'slug' => 'men-denim-jacket',       'price' => 850000, 'variants' => ['blue', 'brown'],                       'child' => 'men-outerwear'],
            ['name' => 'Men Bomber Jacket',     'slug' => 'men-bomber-jacket',      'price' => 950000, 'variants' => ['navy', 'black', 'red', 'white'],       'child' => 'men-outerwear'],
            ['name' => 'Men Puffer Vest',       'slug' => 'men-puffer-vest',        'price' => 700000, 'variants' => ['black', 'brown', 'grey'],              'child' => 'men-outerwear'],

            // BOTTOMS (Quần)
            ['name' => 'Men Chino Shorts',      'slug' => 'men-chino-shorts',       'price' => 350000, 'variants' => ['blue', 'black', 'brown'],              'child' => 'men-bottoms'],
            ['name' => 'Men Denim Shorts',      'slug' => 'men-denim-shorts',       'price' => 380000, 'variants' => ['beige', 'black', 'white'],             'child' => 'men-bottoms'],
            ['name' => 'Men Slim Jeans',        'slug' => 'men-slim-jeans',         'price' => 650000, 'variants' => ['grey', 'black'],                       'child' => 'men-bottoms'],
            ['name' => 'Men Cargo Pants',       'slug' => 'men-cargo-pants',        'price' => 550000, 'variants' => ['green', 'beige', 'navy'],              'child' => 'men-bottoms'],
            ['name' => 'Men Chino Trousers',    'slug' => 'men-chino-trousers',     'price' => 500000, 'variants' => ['beige', 'blue', 'brown'],              'child' => 'men-bottoms'],

            // ACTIVEWEAR
            ['name' => 'Men Joggers',           'slug' => 'men-joggers',            'price' => 420000, 'variants' => ['green', 'black', 'white'],             'child' => 'men-activewear'],
            ['name' => 'Men Sweatpants',        'slug' => 'men-sweatpants',         'price' => 400000, 'variants' => ['grey', 'black', 'white'],              'child' => 'men-activewear'],
            ['name' => 'Men Swim Trunks',       'slug' => 'men-swim-trunks',        'price' => 300000, 'variants' => ['red', 'black', 'navy', 'white'],       'child' => 'men-activewear'],

            // OTHERS (assign to parent 'men')
            ['name' => 'Men Linen Suit',        'slug' => 'men-linen-suit',         'price' => 2500000, 'variants' => ['beige', 'black', 'brown', 'grey'],    'child' => null],
            ['name' => 'Men Oversized Tee',     'slug' => 'men-oversized-tee',      'price' => 280000, 'variants' => ['grey', 'brown', 'black'],              'child' => 'men-tops'],
        ];

        // ==========================================
        // 2. DANH SÁCH NỮ (WOMEN) - 20 SẢN PHẨM
        // ==========================================
        $womenProducts = [
            // DRESSES & SKIRTS
            ['name' => 'Women Silk Dress',      'slug' => 'women-silk-dress',       'price' => 650000, 'variants' => ['green', 'grey', 'white'],              'child' => 'women-dresses'],
            ['name' => 'Women Summer Maxi',     'slug' => 'women-summer-maxi',      'price' => 550000, 'variants' => ['black', 'navy', 'red'],                'child' => 'women-dresses'],
            ['name' => 'Women Bodycon Dress',   'slug' => 'women-bodycon-dress',    'price' => 450000, 'variants' => ['black', 'brown', 'grey'],              'child' => 'women-dresses'],
            ['name' => 'Women Pleated Skirt',   'slug' => 'women-pleated-skirt',    'price' => 320000, 'variants' => ['beige', 'black'],                      'child' => 'women-dresses'],
            ['name' => 'Women Mini Skirt',      'slug' => 'women-mini-skirt',       'price' => 280000, 'variants' => ['red', 'black', 'white'],               'child' => 'women-dresses'],
            ['name' => 'Women Denim Skirt',     'slug' => 'women-denim-skirt',      'price' => 350000, 'variants' => ['beige', 'brown'],                      'child' => 'women-dresses'],

            // TOPS
            ['name' => 'Women Crop Top',        'slug' => 'women-crop-top',         'price' => 150000, 'variants' => ['beige', 'navy'],                       'child' => 'women-tops'],
            ['name' => 'Women Silk Blouse',     'slug' => 'women-silk-blouse',      'price' => 420000, 'variants' => ['grey', 'red'],                         'child' => 'women-tops'],
            ['name' => 'Women Oversized Tee',   'slug' => 'women-oversized-tee',    'price' => 250000, 'variants' => ['white', 'green'],                      'child' => 'women-tops'],
            ['name' => 'Women Knit Cardigan',   'slug' => 'women-knit-cardigan',    'price' => 480000, 'variants' => ['black', 'grey'],                       'child' => 'women-tops'],
            ['name' => 'Women Turtle Neck',     'slug' => 'women-turtle-neck',      'price' => 320000, 'variants' => ['white', 'navy'],                       'child' => 'women-tops'],

            // OUTERWEAR
            ['name' => 'Women Blazer',          'slug' => 'women-blazer',           'price' => 750000, 'variants' => ['black', 'white'],                      'child' => 'women-outerwear'],
            ['name' => 'Women Leather Jacket',  'slug' => 'women-leather-jacket',   'price' => 1200000, 'variants' => ['black', 'brown'],                     'child' => 'women-outerwear'],
            ['name' => 'Women Trench Coat',     'slug' => 'women-trench-coat',      'price' => 1500000, 'variants' => ['brown', 'navy'],                      'child' => 'women-outerwear'],

            // BOTTOMS
            ['name' => 'Women Mom Jeans',       'slug' => 'women-mom-jeans',        'price' => 550000, 'variants' => ['white', 'black'],                      'child' => 'women-bottoms'],
            ['name' => 'Women Skinny Jeans',    'slug' => 'women-skinny-jeans',     'price' => 520000, 'variants' => ['black', 'brown'],                      'child' => 'women-bottoms'],
            ['name' => 'Women Wide Leg Pants',  'slug' => 'women-wide-leg-pants',   'price' => 480000, 'variants' => ['brown', 'black', 'red'],               'child' => 'women-bottoms'],
            ['name' => 'Women Biker Shorts',    'slug' => 'women-biker-shorts',     'price' => 200000, 'variants' => ['grey', 'white'],                       'child' => 'women-bottoms'],
            ['name' => 'Women Linen Shorts',    'slug' => 'women-linen-shorts',     'price' => 280000, 'variants' => ['white'],                               'child' => 'women-bottoms'],
            ['name' => 'Women Yoga Leggings',   'slug' => 'women-yoga-leggings',    'price' => 350000, 'variants' => ['grey'],                                'child' => 'women-bottoms'],
        ];

        // ======================================================
        // DYNAMIC CATEGORY LOOKUP (no hardcoded IDs!)
        // ======================================================
        $menCategory = Category::where('slug', 'men')->firstOrFail();
        $womenCategory = Category::where('slug', 'women')->firstOrFail();

        // Build a slug → id map for all child categories
        $childCategoryMap = Category::whereNotNull('parent_id')->pluck('id', 'slug');

        $this->seedCategory($menProducts, 'men', $menCategory->id, $childCategoryMap);
        $this->seedCategory($womenProducts, 'women', $womenCategory->id, $childCategoryMap);
    }

    private function seedCategory(array $products, string $categoryPrefix, int $parentCategoryId, $childCategoryMap)
    {
        $counter = 1;

        foreach ($products as $item) {
            $firstVariant = $item['variants'][0] ?? 'default';
            $mainImage = "{$firstVariant}.jpg";

            $sku = strtoupper($categoryPrefix) . '-' . str_pad($counter, 3, '0', STR_PAD_LEFT);

            // Use child category if specified, otherwise fall back to parent
            $categoryId = $parentCategoryId;
            if (!empty($item['child']) && $childCategoryMap->has($item['child'])) {
                $categoryId = $childCategoryMap->get($item['child']);
            }

            $productId = DB::table('products')->updateOrInsert(
                ['slug' => $item['slug']],
                [
                    'name' => $item['name'],
                    'sku' => $sku,
                    'description' => "This is a premium {$item['name']} for {$categoryPrefix}.",
                    'category_id' => $categoryId,
                    'base_price' => $item['price'],
                    'stock' => rand(10, 100),
                    'image' => $mainImage,
                    'is_active' => true,
                    'is_new' => rand(0, 1) === 1,
                    'is_bestseller' => rand(0, 1) === 1,
                    'is_on_sale' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Get the product ID for variant insertion
            $productRecord = DB::table('products')->where('slug', $item['slug'])->first();

            $counter++;

            foreach ($item['variants'] as $color) {
                DB::table('product_variants')->updateOrInsert(
                    ['sku' => strtoupper($item['slug']) . '-' . strtoupper($color)],
                    [
                        'product_id' => $productRecord->id,
                        'color_name' => ucfirst($color),
                        'color_hex' => $this->getColorHex($color),
                        'price' => $item['price'],
                        'stock' => rand(10, 100),
                        'image_path' => "products/{$item['slug']}/{$color}.jpg",
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
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