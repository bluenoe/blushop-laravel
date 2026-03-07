<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FragranceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates 29 high-end Perfume products with 50ml and 100ml variants.
     */
    public function run(): void
    {
        // ==========================================
        // DYNAMIC CATEGORY LOOKUP (no hardcoded IDs!)
        // ==========================================
        $fragranceCategory = Category::where('slug', 'fragrance')->firstOrFail();
        $fragranceCategoryId = $fragranceCategory->id;

        // ==========================================
        // LUXURY PERFUME NAMING COLLECTION
        // Inspired by Chanel, Le Labo, Tom Ford styles
        // ==========================================
        $fragrances = [
            'Midnight Bloom',
            'Ocean Breeze',
            'Oud Wood Noir',
            'Velvet Orchid',
            'Amber Mystique',
            'Rose Absolute',
            'Noir Intense',
            'Citrus Soleil',
            'Bergamot Dreams',
            'Sandalwood Essence',
            'Jasmine Whisper',
            'Musk Elixir',
            'Vetiver Royal',
            'Cedar Smoke',
            'Iris Suede',
            'Tonka Divine',
            'Saffron Nights',
            'Patchouli Luxe',
            'Vanilla Noir',
            'Neroli Sunlit',
            'Leather & Sage',
            'Cashmere Mist',
            'Amber Oud',
            'Cardamom Spice',
            'Fig & Moss',
            'White Tea Harmony',
            'Peony Blush',
            'Sea Salt & Wood',
            'Golden Hour',
        ];

        // Luxury fragrance descriptions (rotating)
        $descriptions = [
            'An exquisite blend that captivates the senses with its sophisticated composition. Perfect for evening occasions.',
            'A harmonious fusion of rare ingredients, crafted for those who appreciate true luxury.',
            'Elegance redefined. This signature scent leaves a lasting impression wherever you go.',
            'A modern classic that balances tradition with contemporary sophistication.',
            'Timeless and refined. Each note unfolds like a story of pure elegance.',
        ];

        $this->command->info('🌸 Creating 29 Luxury Fragrance Products...');

        foreach ($fragrances as $index => $name) {
            $i = $index + 1; // 1-indexed for naming convention
            $slug = Str::slug($name);

            // Random base price between 1,500,000 and 3,000,000 VND
            $basePrice = rand(15, 30) * 100000;

            // Price for 100ml = Base × 1.6 (approximately)
            $largePrice = (int) ($basePrice * 1.6);

            // Main product image uses the 50ml variant
            $mainImage = "fragrance_{$i}_50ml.jpg";

            // Insert/Update Product (idempotent via slug)
            DB::table('products')->updateOrInsert(
                ['slug' => $slug],
                [
                    'name'          => $name,
                    'sku'           => "PERF-{$i}-MAIN",
                    'description'   => $descriptions[$index % count($descriptions)],
                    'category_id'   => $fragranceCategoryId,
                    'base_price'    => $basePrice,
                    'stock'         => 30,
                    'image'         => $mainImage,
                    'is_active'     => true,
                    'is_new'        => $index < 5,
                    'is_bestseller' => in_array($index, [0, 3, 7, 12, 18]),
                    'is_on_sale'    => false,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]
            );

            $productRecord = DB::table('products')->where('slug', $slug)->first();
            $productId = $productRecord->id;

            // ==========================================
            // CREATE 50ml VARIANT
            // ==========================================
            DB::table('product_variants')->updateOrInsert(
                ['sku' => "PERF-{$i}-50"],
                [
                    'product_id'  => $productId,
                    'size'        => '50ml',
                    'capacity_ml' => 50,
                    'price'       => $basePrice,
                    'stock'       => 20,
                    'image_path'  => "products/{$slug}/fragrance_{$i}_50ml.jpg",
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]
            );

            // ==========================================
            // CREATE 100ml VARIANT
            // ==========================================
            DB::table('product_variants')->updateOrInsert(
                ['sku' => "PERF-{$i}-100"],
                [
                    'product_id'  => $productId,
                    'size'        => '100ml',
                    'capacity_ml' => 100,
                    'price'       => $largePrice,
                    'stock'       => 10,
                    'image_path'  => "products/{$slug}/fragrance_{$i}_100ml.jpg",
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]
            );

            $this->command->line("   ✓ Created: {$name} (₫" . number_format($basePrice) . " / ₫" . number_format($largePrice) . ")");
        }

        $this->command->info('✅ Fragrance Seeder Complete: 29 Products × 2 Variants = 58 Records');
    }
}