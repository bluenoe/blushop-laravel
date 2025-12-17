<?php

namespace Database\Seeders;

use App\Models\Product;
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
        DB::table('product_variants')->truncate();
        Schema::enableForeignKeyConstraints();

        $now = Carbon::now();

        // Helper lấy ID category
        $getCat = function ($slug) {
            return DB::table('categories')->where('slug', $slug)->value('id');
        };

        // Hàm tự động đoán danh mục quần áo
        $guessCat = function ($name, $gender) use ($getCat) {
            $n = strtolower($name);
            $prefix = $gender === 'men' ? 'men-' : 'women-';
            if (Str::contains($n, ['tee', 'shirt', 'polo', 'top', 'henley', 'tank', 'bodysuit', 'blouse', 'vest', 'sweater', 'cardigan'])) return $getCat($prefix . 'tops');
            if (Str::contains($n, ['hoodie', 'jacket', 'coat', 'bomber', 'blazer', 'puffer', 'trench', 'parka'])) return $getCat($prefix . 'outerwear');
            if (Str::contains($n, ['pant', 'jean', 'chino', 'trouser', 'jogger', 'legging', 'short'])) return $getCat($prefix . 'bottoms');
            if (Str::contains($n, ['dress', 'gown', 'robe'])) return $getCat('women-dresses');
            return $getCat($prefix . 'tops');
        };

        // ==========================================
        // 1. QUẦN ÁO (MEN & WOMEN)
        // ==========================================
        $menItems = [
            'Essential Crew Neck Tee',
            'Heavyweight Oversized Tee',
            'Vintage Wash Graphic Tee',
            'Striped Pocket Tee',
            'Pique Cotton Polo',
            'Merino Wool Polo',
            'Oxford Button Down',
            'Flannel Plaid Shirt',
            'Denim Western Shirt',
            'Everyday Pullover Hoodie',
            'Heavyweight Zip Hoodie',
            'MA-1 Bomber Jacket',
            'Classic Denim Trucker',
            'Tech Windbreaker',
            'Slim Fit Chino Pant',
            'Relaxed Fit Pleated Trouser',
            'Utility Cargo Pant',
            'Tech Fleece Jogger',
            'Slim Tapered Jeans',
            'Carpenter Work Pant',
            'Chino Short 5 Inch',
            'Nylon Swim Trunk',
            'Sweat Short',
            'Cargo Short',
            'Linen Blend Short'
            // (Bà có thể thêm lại list dài cũ nếu muốn, tui rút gọn để code dễ nhìn)
        ];

        $womenItems = [
            'Baby Tee Cropped',
            'Ribbed Tank Top',
            'Silk Camisole',
            'Oversized Graphic Tee',
            'Puff Sleeve Blouse',
            'Linen Button Down',
            'Cropped Knit Cardigan',
            'Cable Knit Sweater',
            'Flowy Maxi Dress',
            'Floral Midi Dress',
            'Satin Slip Dress',
            'Bodycon Mini Dress',
            'Pleated Midi Skirt',
            'Denim Mini Skirt',
            'High Waisted Mom Jeans',
            'Wide Leg Dad Jeans',
            'Tailored Wide Leg Trouser',
            'Biker Short',
            'Classic Trench Coat',
            'Oversized Blazer'
        ];

        $apparelData = [];
        // Xử lý Men
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
        // Xử lý Women
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
        // Insert Apparel
        foreach (array_chunk($apparelData, 50) as $chunk) {
            DB::table('products')->insert($chunk);
        }

        // ==========================================
        // 2. NƯỚC HOA (29 CHAI - Full Variants)
        // ==========================================
        $perfumeList = [
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

        $notesLibrary = [
            'top' => ['Cam Bergamot', 'Tiêu hồng', 'Quả lê', 'Hoa cam', 'Hương biển', 'Chanh vàng', 'Hạnh nhân'],
            'mid' => ['Hoa nhài', 'Hoa hồng', 'Hoa oải hương', 'Da thuộc', 'Cà phê', 'Hoa huệ', 'Ngọc lan tây'],
            'base' => ['Gỗ đàn hương', 'Vani', 'Xạ hương', 'Hổ phách', 'Gỗ tuyết tùng', 'Hoắc hương', 'Thuốc lá']
        ];

        foreach ($perfumeList as $p) {
            $catSlug = match ($p['gender']) {
                'men' => 'fragrance-for-him',
                'women' => 'fragrance-for-her',
                default => 'fragrance-unisex',
            };

            $slug = Str::slug($p['name']);

            // Tạo Product Cha
            $product = Product::create([
                'name' => $p['name'],
                'slug' => $slug,
                'description' => "A masterpiece from {$p['brand']}. This fragrance embodies the spirit of modern elegance.",
                'image' => $slug . '.jpg',
                'category_id' => $getCat($catSlug) ?? $getCat('fragrance-unisex'),
                'type' => 'fragrance',
                'is_new' => rand(0, 1) == 1,
                'is_bestseller' => rand(0, 1) == 1,
                'is_on_sale' => false,
                'price' => 0,
                'specifications' => [
                    'concentration' => 'Eau de Parfum (EDP)',
                    'top_notes' => collect($notesLibrary['top'])->random(2)->values()->all(),
                    'middle_notes' => collect($notesLibrary['mid'])->random(2)->values()->all(),
                    'base_notes' => collect($notesLibrary['base'])->random(3)->values()->all(),
                ]
            ]);

            // Logic giá tiền: Niche vs Designer
            $isNiche = in_array($p['brand'], ['Le Labo', 'Creed', 'Byredo', 'Tom Ford', 'MFK']);
            $basePrice = $isNiche ? 4500000 : 2500000;

            $variants = [
                ['capacity_ml' => 50, 'price' => $basePrice, 'sku' => strtoupper(substr($slug, 0, 3)) . '-50'],
                ['capacity_ml' => 100, 'price' => $basePrice * 1.6, 'sku' => strtoupper(substr($slug, 0, 3)) . '-100']
            ];

            // Update giá hiển thị cho product cha (lấy giá min của variants)
            $product->price = $variants[0]['price'];
            $product->save();

            // Tạo Variants con
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
