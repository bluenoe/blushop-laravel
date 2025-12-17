<?php

namespace Database\Seeders;

use App\Models\Product; // [IMPORT QUAN TRỌNG]
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
        DB::table('product_variants')->truncate(); // [NEW] Truncate bảng variants
        Schema::enableForeignKeyConstraints();

        $now = Carbon::now();

        // Helper lấy ID category
        $getCat = function ($slug) {
            return DB::table('categories')->where('slug', $slug)->value('id');
        };

        // Hàm tự động đoán danh mục
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
        // 1. DATA QUẦN ÁO (MEN) - GIỮ NGUYÊN
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
        // 2. DATA QUẦN ÁO (WOMEN) - GIỮ NGUYÊN
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
        // 3. BULK INSERT QUẦN ÁO (NHANH)
        // ==========================================
        $apparelData = [];

        foreach ($menItems as $name) {
            $apparelData[] = [
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => "Designed for modern living. The {$name} features premium materials.",
                'price' => rand(290, 890) * 1000,
                'image' => Str::slug($name) . '.jpg',
                'category_id' => $guessCat($name, 'men'),
                'type' => 'apparel',
                'is_new' => rand(0, 1) > 0.7,
                'is_bestseller' => rand(0, 1) > 0.8,
                'is_on_sale' => rand(0, 1) > 0.8,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach ($womenItems as $name) {
            $apparelData[] = [
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => "Designed for modern living. The {$name} features premium materials.",
                'price' => rand(190, 990) * 1000,
                'image' => Str::slug($name) . '.jpg',
                'category_id' => $guessCat($name, 'women'),
                'type' => 'apparel',
                'is_new' => rand(0, 1) > 0.7,
                'is_bestseller' => rand(0, 1) > 0.8,
                'is_on_sale' => rand(0, 1) > 0.8,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($apparelData, 50) as $chunk) {
            DB::table('products')->insert($chunk);
        }

        // ================================================================
        // DANH SÁCH 29 NƯỚC HOA (Tên chuẩn - Bà đổi tên ảnh theo slug nhé)
        // ================================================================
        $perfumeList = [
            // --- Niche / High-End (Giá cao) ---
            ['name' => 'Santal 33 - Le Labo',           'brand' => 'Le Labo', 'gender' => 'unisex'],
            ['name' => 'Another 13 - Le Labo',          'brand' => 'Le Labo', 'gender' => 'unisex'],
            ['name' => 'Rose 31 - Le Labo',             'brand' => 'Le Labo', 'gender' => 'unisex'],
            ['name' => 'Baccarat Rouge 540 - MFK',      'brand' => 'MFK',     'gender' => 'unisex'],
            ['name' => 'Aventus - Creed',               'brand' => 'Creed',   'gender' => 'men'],
            ['name' => 'Gypsy Water - Byredo',          'brand' => 'Byredo',  'gender' => 'unisex'],
            ['name' => 'Mojave Ghost - Byredo',         'brand' => 'Byredo',  'gender' => 'unisex'],
            ['name' => 'Tobacco Vanille - Tom Ford',    'brand' => 'Tom Ford', 'gender' => 'unisex'],
            ['name' => 'Oud Wood - Tom Ford',           'brand' => 'Tom Ford', 'gender' => 'unisex'],
            ['name' => 'Lost Cherry - Tom Ford',        'brand' => 'Tom Ford', 'gender' => 'women'],

            // --- Designer (Phổ biến) ---
            ['name' => 'Bleu de Chanel',                'brand' => 'Chanel',  'gender' => 'men'],
            ['name' => 'Coco Mademoiselle',             'brand' => 'Chanel',  'gender' => 'women'],
            ['name' => 'Chanel No.5',                   'brand' => 'Chanel',  'gender' => 'women'],
            ['name' => 'Sauvage - Dior',                'brand' => 'Dior',    'gender' => 'men'],
            ['name' => 'Miss Dior Blooming Bouquet',    'brand' => 'Dior',    'gender' => 'women'],
            ['name' => 'J\'adore - Dior',               'brand' => 'Dior',    'gender' => 'women'],
            ['name' => 'YSL Libre',                     'brand' => 'YSL',     'gender' => 'women'],
            ['name' => 'Black Opium - YSL',             'brand' => 'YSL',     'gender' => 'women'],
            ['name' => 'Y Eau de Parfum - YSL',         'brand' => 'YSL',     'gender' => 'men'],
            ['name' => 'Acqua di Gio - Armani',         'brand' => 'Armani',  'gender' => 'men'],
            ['name' => 'Sì Passione - Armani',          'brand' => 'Armani',  'gender' => 'women'],
            ['name' => 'Gucci Bloom',                   'brand' => 'Gucci',   'gender' => 'women'],
            ['name' => 'Gucci Flora Gorgeous Gardenia', 'brand' => 'Gucci',   'gender' => 'women'],
            ['name' => 'Versace Eros',                  'brand' => 'Versace', 'gender' => 'men'],
            ['name' => 'Versace Bright Crystal',        'brand' => 'Versace', 'gender' => 'women'],
            ['name' => 'Replica Jazz Club',             'brand' => 'Maison',  'gender' => 'men'],
            ['name' => 'Replica Lazy Sunday Morning',   'brand' => 'Maison',  'gender' => 'unisex'],
            ['name' => 'Narciso Rodriguez For Her',     'brand' => 'Narciso', 'gender' => 'women'],
            ['name' => 'Burberry Her',                  'brand' => 'Burberry', 'gender' => 'women'],
        ];

        // Dữ liệu tầng hương mẫu (Random để tạo JSON cho đẹp)
        $notesLibrary = [
            'top' => ['Cam Bergamot', 'Tiêu hồng', 'Quả lê', 'Hoa cam', 'Hương biển', 'Chanh vàng', 'Hạnh nhân'],
            'mid' => ['Hoa nhài', 'Hoa hồng', 'Hoa oải hương', 'Da thuộc', 'Cà phê', 'Hoa huệ', 'Ngọc lan tây'],
            'base' => ['Gỗ đàn hương', 'Vani', 'Xạ hương', 'Hổ phách', 'Gỗ tuyết tùng', 'Hoắc hương', 'Thuốc lá']
        ];

        foreach ($perfumeList as $p) {
            // 1. Xác định Category
            $catSlug = match ($p['gender']) {
                'men' => 'fragrance-for-him', // Đảm bảo slug này có trong DB category
                'women' => 'fragrance-for-her',
                default => 'fragrance-unisex',
            };

            // 2. Tạo Sản phẩm cha
            $slug = Str::slug($p['name']);
            $product = Product::create([
                'name' => $p['name'],
                'slug' => $slug,
                'description' => "A masterpiece from {$p['brand']}. This fragrance embodies the spirit of modern elegance and timeless sophistication.",
                'image' => $slug . '.jpg', // Tên ảnh sẽ là slug.jpg
                'category_id' => $getCat($catSlug) ?? $getCat('fragrance-unisex'),
                'type' => 'fragrance',
                'is_new' => rand(0, 1) == 1,
                'is_bestseller' => rand(0, 1) == 1,
                'is_on_sale' => false,
                'price' => 0, // Giá hiển thị sẽ lấy từ variant thấp nhất
                'specifications' => [
                    'concentration' => 'Eau de Parfum (EDP)',
                    'top_notes' => collect($notesLibrary['top'])->random(2)->values()->all(),
                    'middle_notes' => collect($notesLibrary['mid'])->random(2)->values()->all(),
                    'base_notes' => collect($notesLibrary['base'])->random(3)->values()->all(),
                ]
            ]);

            // 3. Tạo Variants (Logic giá tiền thông minh)
            // Niche (Le Labo, Creed, Tom Ford) đắt hơn Designer (Dior, Versace)
            $isNiche = in_array($p['brand'], ['Le Labo', 'Creed', 'Byredo', 'Tom Ford', 'MFK']);
            $basePrice = $isNiche ? 4500000 : 2500000; // Giá gốc 50ml

            $variants = [
                [
                    'capacity_ml' => 50,
                    'price' => $basePrice,
                    'sku' => strtoupper(substr($slug, 0, 3)) . '-50'
                ],
                [
                    'capacity_ml' => 100,
                    'price' => $basePrice * 1.6, // 100ml rẻ hơn mua 2 chai 50ml
                    'sku' => strtoupper(substr($slug, 0, 3)) . '-100'
                ]
            ];

            // Update giá hiển thị cho product cha (lấy giá min)
            $product->price = $variants[0]['price'];
            $product->save();

            foreach ($variants as $v) {
                $product->variants()->create([
                    'capacity_ml' => $v['capacity_ml'],
                    'price' => $v['price'],
                    'compare_at_price' => null,
                    'sku' => $v['sku'],
                    'stock_quantity' => rand(10, 50),
                    'is_active' => true
                ]);
            }
        }
    }
}
