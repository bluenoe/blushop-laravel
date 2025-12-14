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
        $now = Carbon::now();

        // 1. Helper lấy Category ID an toàn (Nếu không tìm thấy sẽ lấy ID 1 để không lỗi)
        $getCatId = function ($slug) {
            return DB::table('categories')->where('slug', $slug)->value('id')
                ?? DB::table('categories')->value('id');
        };

        // 2. Map ID danh mục (Dựa trên CategorySeeder chuẩn)
        $cats = [
            'men_tops'    => $getCatId('men-t-shirts'),
            'men_hoodies' => $getCatId('men-hoodies'),
            'men_outer'   => $getCatId('men-jackets'),
            'men_bottoms' => $getCatId('men-pants'),

            'wmn_tops'    => $getCatId('women-t-shirts'),
            'wmn_dresses' => $getCatId('women-dresses'),
            'wmn_bottoms' => $getCatId('women-skirts'), // Bao gồm cả váy và quần nữ

            'acc_bags'    => $getCatId('accessories-bags'),
            'acc_caps'    => $getCatId('accessories-caps'),
            'acc_socks'   => $getCatId('accessories-socks'),
            'stationery'  => $getCatId('stationery-notebooks'),
            'tech'        => $getCatId('stationery-tech'),
        ];

        $items = [
            // ==========================================
            // 👔 MEN COLLECTION (Original + 10 New Items)
            // ==========================================
            ['name' => 'Essential Tee - Black',      'price' => 199000, 'cat' => $cats['men_tops'],    'img' => 'men_tee_black.jpg'],
            ['name' => 'Essential Tee - White',      'price' => 199000, 'cat' => $cats['men_tops'],    'img' => 'men_tee_white.jpg'],
            ['name' => 'Essential Tee - Navy',       'price' => 199000, 'cat' => $cats['men_tops'],    'img' => 'men_tee_navy.jpg'],
            ['name' => 'Heavy Cotton Oversized Tee', 'price' => 249000, 'cat' => $cats['men_tops'],    'img' => 'men_oversized_sand.jpg'],
            ['name' => 'Urban Graphic Tee',          'price' => 269000, 'cat' => $cats['men_tops'],    'img' => 'men_graphic_urban.jpg'],
            ['name' => 'Everyday Hoodie - Charcoal', 'price' => 399000, 'cat' => $cats['men_hoodies'], 'img' => 'men_hoodie_charcoal.jpg'],
            ['name' => 'Zip-Up Hoodie - Heather',    'price' => 429000, 'cat' => $cats['men_hoodies'], 'img' => 'men_zip_grey.jpg'],
            ['name' => 'Relaxed Pullover - Navy',    'price' => 359000, 'cat' => $cats['men_hoodies'], 'img' => 'men_pullover_navy.jpg'],
            ['name' => 'MA-1 Bomber Jacket',         'price' => 599000, 'cat' => $cats['men_outer'],   'img' => 'men_bomber.jpg'],
            ['name' => 'Classic Denim Trucker',      'price' => 649000, 'cat' => $cats['men_outer'],   'img' => 'men_denim_jacket.jpg'],
            ['name' => 'Tech Windbreaker',           'price' => 499000, 'cat' => $cats['men_outer'],   'img' => 'men_windbreaker.jpg'],
            ['name' => 'Utility Cargo Pants',        'price' => 459000, 'cat' => $cats['men_bottoms'], 'img' => 'men_cargo_green.jpg'],
            ['name' => 'Slim Fit Chinos - Beige',    'price' => 399000, 'cat' => $cats['men_bottoms'], 'img' => 'men_chinos_beige.jpg'],
            ['name' => 'Daily Joggers - Grey',       'price' => 359000, 'cat' => $cats['men_bottoms'], 'img' => 'men_joggers_grey.jpg'],
            ['name' => 'Tapered Jeans',              'price' => 499000, 'cat' => $cats['men_bottoms'], 'img' => 'men_jeans_slim.jpg'],
            ['name' => 'Chino Shorts - Khaki',       'price' => 299000, 'cat' => $cats['men_bottoms'], 'img' => 'men_shorts_khaki.jpg'],
            ['name' => 'Boxy Fit Pocket Tee',        'price' => 289000, 'cat' => $cats['men_tops'],    'img' => 'men_heavy_olive.jpg'],
            ['name' => 'Breton Striped Tee',         'price' => 229000, 'cat' => $cats['men_tops'],    'img' => 'men_striped_tee.jpg'],
            ['name' => 'Flannel Overshirt',          'price' => 389000, 'cat' => $cats['men_outer'],   'img' => 'men_flannel.jpg'],
            ['name' => 'Varsity Jacket',             'price' => 699000, 'cat' => $cats['men_outer'],   'img' => 'men_varsity.jpg'],
            ['name' => 'Puffer Vest',                'price' => 459000, 'cat' => $cats['men_outer'],   'img' => 'men_puffer_vest.jpg'],
            ['name' => 'Lounge Sweatpants',          'price' => 329000, 'cat' => $cats['men_bottoms'], 'img' => 'men_sweatpants_black.jpg'],
            ['name' => 'Summer Linen Shirt',         'price' => 359000, 'cat' => $cats['men_tops'],    'img' => 'men_linen_shirt.jpg'],
            ['name' => 'Pique Polo - White',         'price' => 299000, 'cat' => $cats['men_tops'],    'img' => 'men_polo_white.jpg'],
            ['name' => 'Pique Polo - Navy',          'price' => 299000, 'cat' => $cats['men_tops'],    'img' => 'men_polo_navy.jpg'],
            ['name' => 'Mock Neck Long Sleeve',      'price' => 349000, 'cat' => $cats['men_tops'],    'img' => 'men_turtleneck.jpg'],
            ['name' => 'Wool Blend Cardigan',        'price' => 499000, 'cat' => $cats['men_outer'],   'img' => 'men_cardigan.jpg'],
            ['name' => 'Retro Track Jacket',         'price' => 429000, 'cat' => $cats['men_outer'],   'img' => 'men_track_jacket.jpg'],
            ['name' => 'Nylon Swim Shorts',          'price' => 249000, 'cat' => $cats['men_bottoms'], 'img' => 'men_swim_shorts.jpg'],
            ['name' => 'Structured Boxy Tee',        'price' => 259000, 'cat' => $cats['men_tops'],    'img' => 'men_boxy_tee.jpg'],
            // --- 10 NEW MEN ITEMS ---
            ['name' => 'Relaxed Fit Jeans',          'price' => 529000, 'cat' => $cats['men_bottoms'], 'img' => 'men_jeans_relaxed.jpg'],
            ['name' => 'Corduroy Button Down',       'price' => 459000, 'cat' => $cats['men_tops'],    'img' => 'men_corduroy_shirt.jpg'],
            ['name' => 'Performance Active Tee',     'price' => 229000, 'cat' => $cats['men_tops'],    'img' => 'men_active_tee.jpg'],
            ['name' => 'Lightweight Running Shorts', 'price' => 259000, 'cat' => $cats['men_bottoms'], 'img' => 'men_running_shorts.jpg'],
            ['name' => 'Graphic Hoodie - Abstract',  'price' => 429000, 'cat' => $cats['men_hoodies'], 'img' => 'men_hoodie_abstract.jpg'],
            ['name' => 'Quarter-Zip Fleece',         'price' => 489000, 'cat' => $cats['men_hoodies'], 'img' => 'men_fleece_zip.jpg'],
            ['name' => 'Slim Fit Dress Shirt',       'price' => 389000, 'cat' => $cats['men_tops'],    'img' => 'men_dress_shirt.jpg'],
            ['name' => 'Pleated Trousers - Black',   'price' => 499000, 'cat' => $cats['men_bottoms'], 'img' => 'men_trousers_pleated.jpg'],
            ['name' => 'Denim Workshirt',            'price' => 459000, 'cat' => $cats['men_tops'],    'img' => 'men_denim_workshirt.jpg'],
            ['name' => 'Faux Leather Biker Jacket',  'price' => 899000, 'cat' => $cats['men_outer'],   'img' => 'men_leather_biker.jpg'],

            // ==========================================
            // 👗 WOMEN COLLECTION (Original + 10 New Items)
            // ==========================================
            ['name' => 'Cropped Tee - White',        'price' => 189000, 'cat' => $cats['wmn_tops'],    'img' => 'wmn_cropped_white.jpg'],
            ['name' => 'Baby Tee - Soft Pink',       'price' => 199000, 'cat' => $cats['wmn_tops'],    'img' => 'wmn_baby_pink.jpg'],
            ['name' => 'Oversized Tee - Lilac',      'price' => 249000, 'cat' => $cats['wmn_tops'],    'img' => 'wmn_oversized_lilac.jpg'],
            ['name' => 'Ribbed Tank Top',            'price' => 159000, 'cat' => $cats['wmn_tops'],    'img' => 'wmn_tank_ribbed.jpg'],
            ['name' => 'Silk Camisole',              'price' => 229000, 'cat' => $cats['wmn_tops'],    'img' => 'wmn_cami_silk.jpg'],
            ['name' => 'Flowy Maxi Dress - Black',   'price' => 459000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_maxi_black.jpg'],
            ['name' => 'Floral Midi Dress',          'price' => 499000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_midi_floral.jpg'],
            ['name' => 'Cocktail Mini Dress - Red',  'price' => 399000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_mini_red.jpg'],
            ['name' => 'Satin Slip Dress',           'price' => 429000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_slip_satin.jpg'],
            ['name' => 'Linen Shirt Dress',          'price' => 459000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_shirt_dress.jpg'],
            ['name' => 'Pleated Midi Skirt',         'price' => 359000, 'cat' => $cats['wmn_bottoms'], 'img' => 'wmn_pleated_grey.jpg'],
            ['name' => 'Denim Mini Skirt',           'price' => 329000, 'cat' => $cats['wmn_bottoms'], 'img' => 'wmn_denim_mini.jpg'],
            ['name' => 'Office Pencil Skirt',        'price' => 299000, 'cat' => $cats['wmn_bottoms'], 'img' => 'wmn_pencil_skirt.jpg'],
            ['name' => 'A-Line Skirt',               'price' => 319000, 'cat' => $cats['wmn_bottoms'], 'img' => 'wmn_aline_skirt.jpg'],
            ['name' => 'Sporty Tennis Skirt',        'price' => 289000, 'cat' => $cats['wmn_bottoms'], 'img' => 'wmn_tennis_skirt.jpg'],
            ['name' => 'Chiffon Blouse',             'price' => 349000, 'cat' => $cats['wmn_tops'],    'img' => 'wmn_blouse_chiffon.jpg'],
            ['name' => 'Off-Shoulder Top',           'price' => 279000, 'cat' => $cats['wmn_tops'],    'img' => 'wmn_offshoulder.jpg'],
            ['name' => 'Seamless Bodysuit',          'price' => 259000, 'cat' => $cats['wmn_tops'],    'img' => 'wmn_bodysuit.jpg'],
            ['name' => 'Knit Vest',                  'price' => 299000, 'cat' => $cats['wmn_tops'],    'img' => 'wmn_knit_vest.jpg'],
            ['name' => 'Wrap Top',                   'price' => 319000, 'cat' => $cats['wmn_tops'],    'img' => 'wmn_wrap_top.jpg'],
            ['name' => 'Wide Leg Jeans',             'price' => 489000, 'cat' => $cats['wmn_bottoms'], 'img' => 'wmn_wideleg_jeans.jpg'],
            ['name' => 'Linen Shorts',               'price' => 269000, 'cat' => $cats['wmn_bottoms'], 'img' => 'wmn_linen_shorts.jpg'],
            ['name' => 'Biker Shorts',               'price' => 199000, 'cat' => $cats['wmn_bottoms'], 'img' => 'wmn_biker_shorts.jpg'],
            ['name' => 'Cream Cardigan',             'price' => 399000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_cardigan_cream.jpg'],
            ['name' => 'Oversized Blazer',           'price' => 699000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_blazer.jpg'],
            ['name' => 'Classic Trench Coat',        'price' => 899000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_trench.jpg'],
            ['name' => 'Cropped Puffer',             'price' => 599000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_puffer.jpg'],
            ['name' => 'Soft Hoodie - Pink',         'price' => 389000, 'cat' => $cats['wmn_tops'],    'img' => 'wmn_hoodie_pink.jpg'],
            ['name' => 'Basic Leggings',             'price' => 229000, 'cat' => $cats['wmn_bottoms'], 'img' => 'wmn_leggings.jpg'],
            ['name' => 'Cozy Lounge Set',            'price' => 499000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_lounge_set.jpg'],
            // --- 10 NEW WOMEN ITEMS ---
            ['name' => 'High-Waisted Mom Jeans',     'price' => 459000, 'cat' => $cats['wmn_bottoms'], 'img' => 'wmn_jeans_mom.jpg'],
            ['name' => 'Ribbed Midi Dress',          'price' => 499000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_dress_ribbed.jpg'],
            ['name' => 'Satin Button Down',          'price' => 359000, 'cat' => $cats['wmn_tops'],    'img' => 'wmn_satin_blouse.jpg'],
            ['name' => 'Graphic Sweatshirt',         'price' => 389000, 'cat' => $cats['wmn_tops'],    'img' => 'wmn_sweatshirt_graphic.jpg'],
            ['name' => 'Faux Leather Leggings',      'price' => 299000, 'cat' => $cats['wmn_bottoms'], 'img' => 'wmn_leggings_leather.jpg'],
            ['name' => 'Cropped Knit Cardigan',      'price' => 329000, 'cat' => $cats['wmn_tops'],    'img' => 'wmn_cardigan_cropped.jpg'],
            ['name' => 'Puff Sleeve Top',            'price' => 259000, 'cat' => $cats['wmn_tops'],    'img' => 'wmn_top_puffsleeve.jpg'],
            ['name' => 'Velvet Slip Dress',          'price' => 559000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_dress_velvet.jpg'],
            ['name' => 'Wide Leg Linen Trousers',    'price' => 429000, 'cat' => $cats['wmn_bottoms'], 'img' => 'wmn_trousers_linen.jpg'],
            ['name' => 'Teddy Bear Coat',            'price' => 799000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_coat_teddy.jpg'],

            // ==========================================
            // 🎒 ACCESSORIES & LIFESTYLE
            // ==========================================
            ['name' => 'Canvas Tote Bag',            'price' => 159000, 'cat' => $cats['acc_bags'],    'img' => 'acc_tote_canvas.jpg'],
            ['name' => 'Minimalist Backpack',        'price' => 349000, 'cat' => $cats['acc_bags'],    'img' => 'acc_backpack_minimal.jpg'],
            ['name' => 'Daily Crossbody',            'price' => 229000, 'cat' => $cats['acc_bags'],    'img' => 'acc_crossbody.jpg'],
            ['name' => 'Utility Belt Bag',           'price' => 189000, 'cat' => $cats['acc_bags'],    'img' => 'acc_belt_bag.jpg'],
            ['name' => 'Laptop Sleeve',              'price' => 199000, 'cat' => $cats['acc_bags'],    'img' => 'acc_laptop_sleeve.jpg'],
            ['name' => 'Travel Duffle',              'price' => 399000, 'cat' => $cats['acc_bags'],    'img' => 'acc_duffle.jpg'],
            ['name' => 'Mini Pouch',                 'price' => 89000,  'cat' => $cats['acc_bags'],    'img' => 'acc_pouch.jpg'],
            ['name' => 'Baseball Cap - Black',       'price' => 149000, 'cat' => $cats['acc_caps'],    'img' => 'acc_cap_black.jpg'],
            ['name' => 'Baseball Cap - Navy',        'price' => 149000, 'cat' => $cats['acc_caps'],    'img' => 'acc_cap_navy.jpg'],
            ['name' => 'Bucket Hat',                 'price' => 159000, 'cat' => $cats['acc_caps'],    'img' => 'acc_bucket_hat.jpg'],
            ['name' => 'Knitted Beanie',             'price' => 129000, 'cat' => $cats['acc_caps'],    'img' => 'acc_beanie.jpg'],
            ['name' => 'Crew Socks - White (3pk)',   'price' => 99000,  'cat' => $cats['acc_socks'],   'img' => 'acc_socks_white.jpg'],
            ['name' => 'Crew Socks - Black (3pk)',   'price' => 99000,  'cat' => $cats['acc_socks'],   'img' => 'acc_socks_black.jpg'],
            ['name' => 'Patterned Socks',            'price' => 89000,  'cat' => $cats['acc_socks'],   'img' => 'acc_socks_pattern.jpg'],
            ['name' => 'Ceramic Mug',                'price' => 99000,  'cat' => $cats['stationery'],  'img' => 'sta_mug_ceramic.jpg'],
            ['name' => 'Enamel Camp Mug',            'price' => 119000, 'cat' => $cats['stationery'],  'img' => 'sta_mug_enamel.jpg'],
            ['name' => 'Steel Tumbler',              'price' => 159000, 'cat' => $cats['stationery'],  'img' => 'sta_tumbler.jpg'],
            ['name' => 'Thermal Bottle',             'price' => 199000, 'cat' => $cats['stationery'],  'img' => 'sta_thermos.jpg'],
            ['name' => 'Classic Notebook A5',        'price' => 79000,  'cat' => $cats['stationery'],  'img' => 'sta_notebook_a5.jpg'],
            ['name' => 'Weekly Planner 2025',        'price' => 129000, 'cat' => $cats['stationery'],  'img' => 'sta_planner.jpg'],
            ['name' => 'Artist Sketchbook',          'price' => 89000,  'cat' => $cats['stationery'],  'img' => 'sta_sketchbook.jpg'],
            ['name' => 'Gel Pen Set',                'price' => 69000,  'cat' => $cats['stationery'],  'img' => 'sta_pens.jpg'],
            ['name' => 'Pro Mouse Pad',              'price' => 89000,  'cat' => $cats['tech'],        'img' => 'sta_mousepad.jpg'],
            ['name' => 'Leather Desk Mat',           'price' => 199000, 'cat' => $cats['tech'],        'img' => 'sta_deskmat.jpg'],
            ['name' => 'Alloy Laptop Stand',         'price' => 299000, 'cat' => $cats['tech'],        'img' => 'sta_laptopstand.jpg'],
            ['name' => 'Cable Organizer',            'price' => 59000,  'cat' => $cats['tech'],        'img' => 'sta_cableorg.jpg'],
            ['name' => 'Sticker Pack - Urban',       'price' => 49000,  'cat' => $cats['stationery'],  'img' => 'sta_sticker1.jpg'],
            ['name' => 'Sticker Pack - Retro',       'price' => 49000,  'cat' => $cats['stationery'],  'img' => 'sta_sticker2.jpg'],
            ['name' => 'Vinyl Decal',                'price' => 29000,  'cat' => $cats['stationery'],  'img' => 'sta_vinyl.jpg'],
            ['name' => 'Phone Case 13 Pro',          'price' => 99000,  'cat' => $cats['tech'],        'img' => 'acc_phonecase13.jpg'],
            ['name' => 'Phone Case 14 Pro',          'price' => 99000,  'cat' => $cats['tech'],        'img' => 'acc_phonecase14.jpg'],
            ['name' => 'Airpods Case',               'price' => 79000,  'cat' => $cats['tech'],        'img' => 'acc_airpods.jpg'],
            ['name' => 'Leather Keyring',            'price' => 39000,  'cat' => $cats['acc_bags'],    'img' => 'acc_keyring.jpg'],
            ['name' => 'ID Lanyard',                 'price' => 49000,  'cat' => $cats['acc_bags'],    'img' => 'acc_lanyard.jpg'],
            ['name' => 'Slim Leather Wallet',        'price' => 299000, 'cat' => $cats['acc_bags'],    'img' => 'acc_wallet.jpg'],
            ['name' => 'Card Holder',                'price' => 159000, 'cat' => $cats['acc_bags'],    'img' => 'acc_cardholder.jpg'],
            ['name' => 'Retro Sunglasses',           'price' => 199000, 'cat' => $cats['acc_caps'],    'img' => 'acc_sunglasses.jpg'],
            ['name' => 'Compact Umbrella',           'price' => 179000, 'cat' => $cats['acc_bags'],    'img' => 'acc_umbrella.jpg'],
            ['name' => 'EVA Raincoat',               'price' => 199000, 'cat' => $cats['men_outer'],   'img' => 'acc_raincoat.jpg'],
            ['name' => 'TPE Yoga Mat',               'price' => 359000, 'cat' => $cats['acc_bags'],    'img' => 'acc_yogamat.jpg'],
        ];

        // Chuẩn bị dữ liệu insert hàng loạt
        $data = [];
        foreach ($items as $item) {
            $data[] = [
                'name'          => $item['name'],
                'slug'          => Str::slug($item['name']), // Đảm bảo có slug để không lỗi
                'description'   => "Designed for modern living. The " . $item['name'] . " features premium materials and a minimalist aesthetic typical of BluShop.",
                'price'         => $item['price'],
                'image'         => $item['img'],
                'category_id'   => $item['cat'],
                'is_new'        => rand(0, 1) > 0.7,
                'is_bestseller' => rand(0, 1) > 0.8,
                'is_on_sale'    => rand(0, 1) > 0.8,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        // Insert từng cục 50 món cho nhẹ DB
        foreach (array_chunk($data, 50) as $chunk) {
            DB::table('products')->insert($chunk);
        }
    }
}
