<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\Review;
use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Categories
        $categories = [
            ['name' => 'Bags', 'slug' => 'bags', 'description' => 'Premium leather bags'],
            ['name' => 'Shoes', 'slug' => 'shoes', 'description' => 'Luxury footwear'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'description' => 'Fashion accessories'],
            ['name' => 'Clothing', 'slug' => 'clothing', 'description' => 'Designer clothing'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Create Colors
        $colors = [
            ['name' => 'Black', 'hex' => '#000000'],
            ['name' => 'Brown', 'hex' => '#8B4513'],
            ['name' => 'Navy', 'hex' => '#000080'],
            ['name' => 'Beige', 'hex' => '#F5F5DC'],
            ['name' => 'White', 'hex' => '#FFFFFF'],
            ['name' => 'Gray', 'hex' => '#808080'],
        ];

        foreach ($colors as $color) {
            Color::create($color);
        }

        // Create Sizes
        $sizes = [
            ['name' => 'XS', 'code' => 'XS', 'sort_order' => 1],
            ['name' => 'S', 'code' => 'S', 'sort_order' => 2],
            ['name' => 'M', 'code' => 'M', 'sort_order' => 3],
            ['name' => 'L', 'code' => 'L', 'sort_order' => 4],
            ['name' => 'XL', 'code' => 'XL', 'sort_order' => 5],
            ['name' => 'One Size', 'code' => 'OS', 'sort_order' => 6],
        ];

        foreach ($sizes as $size) {
            Size::create($size);
        }

        // Sample Product 1: Leather Tote Bag
        $product1 = Product::create([
            'name' => 'Classic Leather Tote Bag',
            'slug' => 'classic-leather-tote-bag',
            'description' => 'Timeless elegance meets modern functionality in this handcrafted leather tote. Perfect for daily essentials with a sophisticated touch.',
            'price' => 2500000,
            'sale_price' => 2000000,
            'sku' => 'BAG-TOTE-001',
            'stock' => 50,
            'category_id' => 1,
            'is_active' => true,
            'is_on_sale' => true,
            'is_new' => true,
            'specifications' => [
                'Material' => '100% Genuine Calf Leather',
                'Dimensions' => '35cm x 30cm x 15cm',
                'Weight' => '850g',
                'Interior' => 'Fabric lining with zipper pocket',
                'Hardware' => 'Gold-tone metal',
                'Made In' => 'Italy',
            ],
            'care_guide' => "Do not wash. Do not bleach.\nDo not iron. Do not dry clean.\nClean with a soft dry cloth.\nKeep away from direct heat and sunlight.\nStore in dust bag when not in use.",
            'meta_title' => 'Classic Leather Tote Bag - Premium Quality',
            'meta_description' => 'Shop our handcrafted classic leather tote bag. Timeless design, premium materials, perfect for everyday use.',
        ]);

        // Add images for product 1
        $product1->images()->createMany([
            ['url' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=800', 'alt_text' => 'Leather tote front view', 'sort_order' => 1, 'is_primary' => true],
            ['url' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=800', 'alt_text' => 'Leather tote side view', 'sort_order' => 2],
            ['url' => 'https://images.unsplash.com/photo-1566150905458-1bf1fc113f0d?w=800', 'alt_text' => 'Leather tote interior', 'sort_order' => 3],
            ['url' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=800', 'alt_text' => 'Leather tote detail', 'sort_order' => 4],
        ]);

        // Add colors and sizes
        $product1->colors()->attach([1 => ['stock' => 20], 2 => ['stock' => 30]]);
        $product1->sizes()->attach([6 => ['stock' => 50]]);

        // Sample Product 2: Designer Heels
        $product2 = Product::create([
            'name' => 'Elegant Suede Heels',
            'slug' => 'elegant-suede-heels',
            'description' => 'Step into sophistication with these elegant suede heels. Perfectly balanced for comfort and style.',
            'price' => 1800000,
            'sku' => 'SHOE-HEEL-001',
            'stock' => 30,
            'category_id' => 2,
            'is_active' => true,
            'is_featured' => true,
            'specifications' => [
                'Material' => 'Premium Suede',
                'Heel Height' => '9 cm',
                'Sole' => 'Leather',
                'Closure' => 'Slip-on',
                'Made In' => 'Spain',
            ],
            'care_guide' => "Use suede brush to remove dirt.\nAvoid water and moisture.\nStore with shoe trees.\nApply suede protector spray.",
        ]);

        $product2->images()->createMany([
            ['url' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=800', 'alt_text' => 'Suede heels front', 'sort_order' => 1, 'is_primary' => true],
            ['url' => 'https://images.unsplash.com/photo-1535043934128-cf0b28d52f95?w=800', 'alt_text' => 'Suede heels side', 'sort_order' => 2],
            ['url' => 'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?w=800', 'alt_text' => 'Suede heels detail', 'sort_order' => 3],
        ]);

        $product2->colors()->attach([1 => ['stock' => 10], 4 => ['stock' => 20]]);
        $product2->sizes()->attach([2 => ['stock' => 5], 3 => ['stock' => 15], 4 => ['stock' => 10]]);

        // Sample Product 3: Silk Scarf
        $product3 = Product::create([
            'name' => 'Hand-Painted Silk Scarf',
            'slug' => 'hand-painted-silk-scarf',
            'description' => 'A luxurious hand-painted silk scarf featuring abstract botanical patterns. Each piece is unique.',
            'price' => 850000,
            'sku' => 'ACC-SCARF-001',
            'stock' => 25,
            'category_id' => 3,
            'is_active' => true,
            'specifications' => [
                'Material' => '100% Silk',
                'Dimensions' => '90cm x 90cm',
                'Pattern' => 'Hand-painted botanical',
                'Edge' => 'Hand-rolled hem',
                'Made In' => 'France',
            ],
            'care_guide' => "Dry clean only.\nIron on low heat.\nAvoid contact with perfume and cosmetics.",
        ]);

        $product3->images()->createMany([
            ['url' => 'https://images.unsplash.com/photo-1520903920243-00d872a2d1c9?w=800', 'alt_text' => 'Silk scarf pattern', 'sort_order' => 1, 'is_primary' => true],
            ['url' => 'https://images.unsplash.com/photo-1601924994987-69e26d50dc26?w=800', 'alt_text' => 'Silk scarf folded', 'sort_order' => 2],
        ]);

        $product3->colors()->attach([4 => ['stock' => 15], 5 => ['stock' => 10]]);
        $product3->sizes()->attach([6 => ['stock' => 25]]);

        // Create Complete the Look relationships
        $product1->completeLookProducts()->attach([$product2->id, $product3->id]);
        $product2->completeLookProducts()->attach([$product1->id, $product3->id]);

        // Create sample reviews (requires at least one user)
        $user = User::first() ?? User::factory()->create([
            'name' => 'Sample Customer',
            'email' => 'customer@example.com',
        ]);

        Review::create([
            'user_id' => $user->id,
            'product_id' => $product1->id,
            'rating' => 5,
            'fit_rating' => 3,
            'comment' => 'Absolutely love this bag! The leather quality is exceptional and it fits all my daily essentials perfectly. The craftsmanship is evident in every detail.',
            'is_verified_purchase' => true,
        ]);

        Review::create([
            'user_id' => $user->id,
            'product_id' => $product2->id,
            'rating' => 4,
            'fit_rating' => 3,
            'comment' => 'Beautiful heels! Very comfortable for the height. I wore them all day at a wedding and my feet didn\'t hurt at all. True to size.',
            'is_verified_purchase' => true,
        ]);

        // Create additional users and reviews
        for ($i = 0; $i < 5; $i++) {
            $tempUser = User::factory()->create();

            Review::create([
                'user_id' => $tempUser->id,
                'product_id' => $product1->id,
                'rating' => rand(4, 5),
                'fit_rating' => rand(2, 4),
                'comment' => $this->getRandomReviewComment(),
                'is_verified_purchase' => rand(0, 1),
            ]);
        }

        // Update product averages
        foreach ([$product1, $product2] as $product) {
            $product->update([
                'avg_rating' => $product->reviews->avg('rating'),
                'review_count' => $product->reviews->count(),
            ]);
        }

        $this->command->info('Products seeded successfully!');
    }

    /**
     * Get random review comments
     */
    private function getRandomReviewComment(): string
    {
        $comments = [
            'Great quality product! Highly recommended.',
            'Exceeded my expectations. Will buy again.',
            'Perfect for everyday use. Love the design.',
            'Good value for money. Fast shipping too.',
            'Beautiful craftsmanship. Worth every penny.',
            'Exactly as described. Very satisfied.',
            'Premium quality and elegant design.',
            'My new favorite purchase!',
        ];

        return $comments[array_rand($comments)];
    }
}
