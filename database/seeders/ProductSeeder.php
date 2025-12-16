<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('products')->truncate();
        Schema::enableForeignKeyConstraints();

        $now = Carbon::now();

        // Helper lấy ID category
        $getCat = function ($slug) {
            return DB::table('categories')->where('slug', $slug)->value('id');
        };

        // Hàm tự động đoán danh mục dựa trên tên sản phẩm
        $guessCat = function ($name, $gender) use ($getCat) {
            $n = strtolower($name);
            $prefix = $gender === 'men' ? 'men-' : 'women-';

            if (Str::contains($n, ['tee', 'shirt', 'polo', 'top', 'henley', 'tank', 'camisole', 'bodysuit', 'blouse', 'vest', 'sweater', 'cardigan', 'crewneck', 'mock neck'])) return $getCat($prefix . 'tops');
            if (Str::contains($n, ['hoodie', 'jacket', 'coat', 'bomber', 'blazer', 'puffer', 'trench', 'windbreaker', 'pullover', 'parka', 'overshirt'])) return $getCat($prefix . 'outerwear');
            if (Str::contains($n, ['pant', 'jean', 'chino', 'trouser', 'jogger', 'legging', 'sweatpant', 'skirt', 'short'])) return $getCat($prefix . 'bottoms');
            if (Str::contains($n, ['dress', 'gown', 'robe'])) return $getCat('women-dresses');

            return $getCat($prefix . 'tops'); // Fallback
        };

        // ==========================================
        // 1. DANH SÁCH 85 SẢN PHẨM NAM (MEN)
        // ==========================================
        $menItems = [
            'Essential Crew Neck Tee',
            'Heavyweight Oversized Tee',
            'Vintage Wash Graphic Tee',
            'Striped Pocket Tee',
            'Performance Active Tee',
            'Pique Cotton Polo',
            'Merino Wool Polo',
            'Linen Blend Camp Shirt',
            'Oxford Button Down',
            'Flannel Plaid Shirt',
            'Denim Western Shirt',
            'Corduroy Overshirt',
            'Mock Neck Long Sleeve',
            'Waffle Knit Henley',
            'Thermal Long Sleeve',
            'Everyday Pullover Hoodie',
            'Heavyweight Zip Hoodie',
            'French Terry Sweatshirt',
            'Drop Shoulder Crewneck',
            'Vintage Wash Sweatshirt',
            'MA-1 Bomber Jacket',
            'Classic Denim Trucker',
            'Varsity Letterman Jacket',
            'Tech Windbreaker',
            'Nylon Puffer Vest',
            'Canvas Chore Coat',
            'Harrington Jacket',
            'Sherpa Lined Trucker',
            'Waterproof Parka',
            'Quilted Liner Jacket',
            'Faux Leather Biker',
            'Wool Blend Peacoat',
            'Technical Field Jacket',
            'Lightweight Coach Jacket',
            'Fleece Zip Jacket',
            'Slim Fit Chino Pant',
            'Straight Leg Chino',
            'Relaxed Fit Pleated Trouser',
            'Utility Cargo Pant',
            'Tech Fleece Jogger',
            'Tapered Sweatpant',
            'Slim Tapered Jeans',
            'Straight Leg Vintage Jeans',
            'Skinny Fit Stretch Jeans',
            'Carpenter Work Pant',
            'Corduroy Carpenter Pant',
            'Linen Drawstring Trouser',
            'Ripstop Cargo Pant',
            'Nylon Track Pant',
            'Hybrid Golf Pant',
            'Chino Short 5 Inch',
            'Chino Short 7 Inch',
            'Nylon Swim Trunk',
            'Board Short',
            'Sweat Short',
            'Mesh Athletic Short',
            'Cargo Short',
            'Pleated Dress Short',
            'Linen Blend Short',
            'Running Performance Short',
            'Structured Boxy Tee',
            'Raw Hem Cropped Tee',
            'Tie Dye Graphic Tee',
            'Bandana Print Shirt',
            'Cuban Collar Shirt',
            'Knitted Polo Shirt',
            'Zip Neck Polo',
            'Raglan Baseball Tee',
            'Sleeveless Muscle Tee',
            'Oversized Pocket Tee',
            'Track Jacket Retro',
            'Souvenir Jacket',
            'Suede Bomber Jacket',
            'Down Puffer Jacket',
            'Trench Coat Beige',
            'Wide Leg Denim',
            'Baggy Carpenter Jean',
            'Bootcut Jean',
            'Raw Denim Selvedge',
            'Double Knee Work Pant',
            'Tech Commuter Pant',
            'Smart Ankle Pant',
            'Jersey Lounge Short',
            'Retro Basketball Short',
            'Seersucker Short'
        ];

        // ==========================================
        // 2. DANH SÁCH 81 SẢN PHẨM NỮ (WOMEN)
        // ==========================================
        $womenItems = [
            'Baby Tee Cropped',
            'Ribbed Tank Top',
            'Silk Camisole',
            'Oversized Graphic Tee',
            'Boxy Fit Cotton Tee',
            'Striped Long Sleeve',
            'Square Neck Bodysuit',
            'Off Shoulder Top',
            'Puff Sleeve Blouse',
            'Linen Button Down',
            'Satin Wrap Top',
            'Chiffon Peplum Top',
            'Cropped Knit Cardigan',
            'Cable Knit Sweater',
            'Turtleneck Ribbed Top',
            'Cashmere Crewneck',
            'V-Neck Slouchy Sweater',
            'Oversized Poplin Shirt',
            'Tie Front Crop Top',
            'Sheer Mesh Top',
            'Flowy Maxi Dress',
            'Floral Midi Dress',
            'Satin Slip Dress',
            'Ribbed Knit Midi Dress',
            'Cocktail Mini Dress',
            'Linen Shirt Dress',
            'Wrap Midi Dress',
            'Bodycon Mini Dress',
            'Boho Tiered Dress',
            'Velvet Slip Dress',
            'Cut Out Midi Dress',
            'Backless Summer Dress',
            'Tweed Mini Dress',
            'Ruched Party Dress',
            'Denim Overall Dress',
            'Pleated Midi Skirt',
            'Satin Midi Skirt',
            'Denim Mini Skirt',
            'Tennis Skirt',
            'A-Line Mini Skirt',
            'Maxi Boho Skirt',
            'Pencil Skirt Office',
            'Cargo Mini Skirt',
            'Leather Mini Skirt',
            'Tiered Ruffle Skirt',
            'High Waisted Mom Jeans',
            'Wide Leg Dad Jeans',
            'Straight Leg Vintage Jeans',
            'Skinny High Rise Jeans',
            'Flare Leg Jeans',
            'Cargo Parachute Pant',
            'Tailored Wide Leg Trouser',
            'Linen Paloma Pant',
            'Faux Leather Legging',
            'Yoga Flare Legging',
            'Biker Short',
            'Denim Mom Short',
            'Linen High Waist Short',
            'Tailored Bermuda Short',
            'Sweat Short Cozy',
            'Classic Trench Coat',
            'Oversized Blazer',
            'Cropped Puffer Jacket',
            'Wool Blend Coat',
            'Denim Sherpa Jacket',
            'Faux Fur Coat',
            'Leather Moto Jacket',
            'Teddy Bear Coat',
            'Quilted Barn Jacket',
            'Tech Windbreaker',
            'Cropped Tweed Jacket',
            'Soft Lounge Set',
            'Waffle Knit Lounge Set',
            'Velour Tracksuit',
            'Pajama Silk Set',
            'Active Racerback Bra',
            'Seamless Legging Set',
            'Tennis Dress',
            'One Piece Swimsuit',
            'High Waist Bikini',
            'Sarong Wrap'
        ];

        // ==========================================
        // 3. XỬ LÝ DỮ LIỆU
        // ==========================================
        $data = [];

        // Xử lý Men (85 items)
        foreach ($menItems as $name) {
            $data[] = [
                'name'          => $name,
                'slug'          => Str::slug($name),
                'description'   => "Designed for modern living. The {$name} features premium materials and a minimalist aesthetic typical of BluShop.",
                'price'         => rand(290, 890) * 1000, // Giá random từ 290k đến 890k
                'image'         => Str::slug($name) . '.jpg',
                'category_id'   => $guessCat($name, 'men'),
                'type'          => 'apparel',
                'is_new'        => rand(0, 1) > 0.7,
                'is_bestseller' => rand(0, 1) > 0.8,
                'is_on_sale'    => rand(0, 1) > 0.8,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        // Xử lý Women (81 items)
        foreach ($womenItems as $name) {
            $data[] = [
                'name'          => $name,
                'slug'          => Str::slug($name),
                'description'   => "Designed for modern living. The {$name} features premium materials and a minimalist aesthetic typical of BluShop.",
                'price'         => rand(190, 990) * 1000,
                'image'         => Str::slug($name) . '.jpg',
                'category_id'   => $guessCat($name, 'women'),
                'type'          => 'apparel',
                'is_new'        => rand(0, 1) > 0.7,
                'is_bestseller' => rand(0, 1) > 0.8,
                'is_on_sale'    => rand(0, 1) > 0.8,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        // Thêm vài chai nước hoa cho sang
        $fragrances = [
            ['name' => 'Santal 33 - Le Labo', 'price' => 4500000, 'cat' => 'fragrance-unisex'],
            ['name' => 'Bleu de Chanel',      'price' => 3200000, 'cat' => 'fragrance-for-him'],
            ['name' => 'YSL Libre',           'price' => 2900000, 'cat' => 'fragrance-for-her'],
        ];

        foreach ($fragrances as $item) {
            $data[] = [
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'description' => 'Luxury fragrance.',
                'price' => $item['price'],
                'image' => Str::slug($item['name']) . '.jpg',
                'category_id' => $getCat($item['cat']),
                'type' => 'fragrance',
                'is_new' => false,
                'is_bestseller' => true,
                'is_on_sale' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insert theo chunk để không bị quá tải
        foreach (array_chunk($data, 50) as $chunk) {
            DB::table('products')->insert($chunk);
        }
    }
}
