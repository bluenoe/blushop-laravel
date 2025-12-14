<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Helper function để lấy ID category theo slug (đảm bảo chính xác)
        $getCatId = fn($slug) => DB::table('categories')->where('slug', $slug)->value('id');

        // Lấy ID các danh mục con để dùng bên dưới
        $cats = [
            'men_tshirts' => $getCatId('men-t-shirts'),
            'men_hoodies' => $getCatId('men-hoodies'),
            'men_jackets' => $getCatId('men-jackets'),
            'men_pants'   => $getCatId('men-pants'),
            'wmn_tshirts' => $getCatId('women-t-shirts'),
            'wmn_dresses' => $getCatId('women-dresses'),
            'wmn_skirts'  => $getCatId('women-skirts'),
            'acc_bags'    => $getCatId('accessories-bags'),
            'acc_caps'    => $getCatId('accessories-caps'),
            'acc_socks'   => $getCatId('accessories-socks'),
            'sta_mugs'    => $getCatId('stationery-mugs'),
            'sta_books'   => $getCatId('stationery-notebooks'),
            'sta_tech'    => $getCatId('stationery-tech'),
            'sta_stickers' => $getCatId('stationery-stickers'),
        ];

        // Nếu database chưa chạy category seeder, mảng trên sẽ null. 
        // Bà nhớ chạy php artisan db:seed --class=CategorySeeder trước nhé!

        $products = [
            // --- MEN COLLECTION (30 items) ---
            ['name' => 'Blu Basic Tee - Black', 'price' => 199000, 'cat' => $cats['men_tshirts'], 'img' => 'men_tee_black.jpg'],
            ['name' => 'Blu Basic Tee - White', 'price' => 199000, 'cat' => $cats['men_tshirts'], 'img' => 'men_tee_white.jpg'],
            ['name' => 'Blu Basic Tee - Navy', 'price' => 199000, 'cat' => $cats['men_tshirts'], 'img' => 'men_tee_navy.jpg'],
            ['name' => 'Blu Oversized Tee - Sand', 'price' => 249000, 'cat' => $cats['men_tshirts'], 'img' => 'men_oversized_sand.jpg'],
            ['name' => 'Blu Graphic Tee - Urban', 'price' => 269000, 'cat' => $cats['men_tshirts'], 'img' => 'men_graphic_urban.jpg'],
            ['name' => 'Blu Hoodie - Charcoal', 'price' => 399000, 'cat' => $cats['men_hoodies'], 'img' => 'men_hoodie_charcoal.jpg'],
            ['name' => 'Blu Zip Hoodie - Grey', 'price' => 429000, 'cat' => $cats['men_hoodies'], 'img' => 'men_zip_grey.jpg'],
            ['name' => 'Blu Pullover - Navy', 'price' => 359000, 'cat' => $cats['men_hoodies'], 'img' => 'men_pullover_navy.jpg'],
            ['name' => 'Blu Bomber Jacket', 'price' => 599000, 'cat' => $cats['men_jackets'], 'img' => 'men_bomber.jpg'],
            ['name' => 'Blu Denim Jacket', 'price' => 649000, 'cat' => $cats['men_jackets'], 'img' => 'men_denim_jacket.jpg'],
            ['name' => 'Blu Windbreaker - Black', 'price' => 499000, 'cat' => $cats['men_jackets'], 'img' => 'men_windbreaker.jpg'],
            ['name' => 'Blu Cargo Pants - Green', 'price' => 459000, 'cat' => $cats['men_pants'], 'img' => 'men_cargo_green.jpg'],
            ['name' => 'Blu Chinos - Beige', 'price' => 399000, 'cat' => $cats['men_pants'], 'img' => 'men_chinos_beige.jpg'],
            ['name' => 'Blu Joggers - Grey', 'price' => 359000, 'cat' => $cats['men_pants'], 'img' => 'men_joggers_grey.jpg'],
            ['name' => 'Blu Jeans - Slim Fit', 'price' => 499000, 'cat' => $cats['men_pants'], 'img' => 'men_jeans_slim.jpg'],
            ['name' => 'Blu Shorts - Khaki', 'price' => 299000, 'cat' => $cats['men_pants'], 'img' => 'men_shorts_khaki.jpg'],
            ['name' => 'Blu Heavy Tee - Olive', 'price' => 289000, 'cat' => $cats['men_tshirts'], 'img' => 'men_heavy_olive.jpg'],
            ['name' => 'Blu Striped Tee', 'price' => 229000, 'cat' => $cats['men_tshirts'], 'img' => 'men_striped_tee.jpg'],
            ['name' => 'Blu Flannel Shirt', 'price' => 389000, 'cat' => $cats['men_jackets'], 'img' => 'men_flannel.jpg'],
            ['name' => 'Blu Varsity Jacket', 'price' => 699000, 'cat' => $cats['men_jackets'], 'img' => 'men_varsity.jpg'],
            ['name' => 'Blu Puffer Vest', 'price' => 459000, 'cat' => $cats['men_jackets'], 'img' => 'men_puffer_vest.jpg'],
            ['name' => 'Blu Sweatpants - Black', 'price' => 329000, 'cat' => $cats['men_pants'], 'img' => 'men_sweatpants_black.jpg'],
            ['name' => 'Blu Linen Shirt', 'price' => 359000, 'cat' => $cats['men_tshirts'], 'img' => 'men_linen_shirt.jpg'],
            ['name' => 'Blu Polo - White', 'price' => 299000, 'cat' => $cats['men_tshirts'], 'img' => 'men_polo_white.jpg'],
            ['name' => 'Blu Polo - Navy', 'price' => 299000, 'cat' => $cats['men_tshirts'], 'img' => 'men_polo_navy.jpg'],
            ['name' => 'Blu Turtleneck - Black', 'price' => 349000, 'cat' => $cats['men_tshirts'], 'img' => 'men_turtleneck.jpg'],
            ['name' => 'Blu Cardigan - Wool', 'price' => 499000, 'cat' => $cats['men_jackets'], 'img' => 'men_cardigan.jpg'],
            ['name' => 'Blu Track Jacket', 'price' => 429000, 'cat' => $cats['men_jackets'], 'img' => 'men_track_jacket.jpg'],
            ['name' => 'Blu Swim Shorts', 'price' => 249000, 'cat' => $cats['men_pants'], 'img' => 'men_swim_shorts.jpg'],
            ['name' => 'Blu Boxy Tee', 'price' => 259000, 'cat' => $cats['men_tshirts'], 'img' => 'men_boxy_tee.jpg'],

            // --- WOMEN COLLECTION (30 items) ---
            ['name' => 'Wmn Cropped Tee - White', 'price' => 189000, 'cat' => $cats['wmn_tshirts'], 'img' => 'wmn_cropped_white.jpg'],
            ['name' => 'Wmn Baby Tee - Pink', 'price' => 199000, 'cat' => $cats['wmn_tshirts'], 'img' => 'wmn_baby_pink.jpg'],
            ['name' => 'Wmn Oversized Tee - Lilac', 'price' => 249000, 'cat' => $cats['wmn_tshirts'], 'img' => 'wmn_oversized_lilac.jpg'],
            ['name' => 'Wmn Tank Top - Ribbed', 'price' => 159000, 'cat' => $cats['wmn_tshirts'], 'img' => 'wmn_tank_ribbed.jpg'],
            ['name' => 'Wmn Camisole - Silk', 'price' => 229000, 'cat' => $cats['wmn_tshirts'], 'img' => 'wmn_cami_silk.jpg'],
            ['name' => 'Wmn Maxi Dress - Black', 'price' => 459000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_maxi_black.jpg'],
            ['name' => 'Wmn Midi Dress - Floral', 'price' => 499000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_midi_floral.jpg'],
            ['name' => 'Wmn Mini Dress - Red', 'price' => 399000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_mini_red.jpg'],
            ['name' => 'Wmn Slip Dress - Satin', 'price' => 429000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_slip_satin.jpg'],
            ['name' => 'Wmn Shirt Dress - Beige', 'price' => 459000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_shirt_dress.jpg'],
            ['name' => 'Wmn Pleated Skirt - Grey', 'price' => 359000, 'cat' => $cats['wmn_skirts'], 'img' => 'wmn_pleated_grey.jpg'],
            ['name' => 'Wmn Denim Skirt - Mini', 'price' => 329000, 'cat' => $cats['wmn_skirts'], 'img' => 'wmn_denim_mini.jpg'],
            ['name' => 'Wmn Pencil Skirt', 'price' => 299000, 'cat' => $cats['wmn_skirts'], 'img' => 'wmn_pencil_skirt.jpg'],
            ['name' => 'Wmn A-Line Skirt', 'price' => 319000, 'cat' => $cats['wmn_skirts'], 'img' => 'wmn_aline_skirt.jpg'],
            ['name' => 'Wmn Tennis Skirt', 'price' => 289000, 'cat' => $cats['wmn_skirts'], 'img' => 'wmn_tennis_skirt.jpg'],
            ['name' => 'Wmn Blouse - Chiffon', 'price' => 349000, 'cat' => $cats['wmn_tshirts'], 'img' => 'wmn_blouse_chiffon.jpg'],
            ['name' => 'Wmn Off-Shoulder Top', 'price' => 279000, 'cat' => $cats['wmn_tshirts'], 'img' => 'wmn_offshoulder.jpg'],
            ['name' => 'Wmn Bodysuit - Black', 'price' => 259000, 'cat' => $cats['wmn_tshirts'], 'img' => 'wmn_bodysuit.jpg'],
            ['name' => 'Wmn Knit Vest', 'price' => 299000, 'cat' => $cats['wmn_tshirts'], 'img' => 'wmn_knit_vest.jpg'],
            ['name' => 'Wmn Wrap Top', 'price' => 319000, 'cat' => $cats['wmn_tshirts'], 'img' => 'wmn_wrap_top.jpg'],
            ['name' => 'Wmn Wide Leg Jeans', 'price' => 489000, 'cat' => $cats['wmn_skirts'], 'img' => 'wmn_wideleg_jeans.jpg'], // Tạm map vào skirts/bottoms
            ['name' => 'Wmn Linen Shorts', 'price' => 269000, 'cat' => $cats['wmn_skirts'], 'img' => 'wmn_linen_shorts.jpg'],
            ['name' => 'Wmn Biker Shorts', 'price' => 199000, 'cat' => $cats['wmn_skirts'], 'img' => 'wmn_biker_shorts.jpg'],
            ['name' => 'Wmn Cardigan - Cream', 'price' => 399000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_cardigan_cream.jpg'], // Tạm
            ['name' => 'Wmn Blazer - Oversized', 'price' => 699000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_blazer.jpg'],
            ['name' => 'Wmn Trench Coat', 'price' => 899000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_trench.jpg'],
            ['name' => 'Wmn Puffer Jacket', 'price' => 599000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_puffer.jpg'],
            ['name' => 'Wmn Hoodie - Pink', 'price' => 389000, 'cat' => $cats['wmn_tshirts'], 'img' => 'wmn_hoodie_pink.jpg'],
            ['name' => 'Wmn Leggings - Black', 'price' => 229000, 'cat' => $cats['wmn_skirts'], 'img' => 'wmn_leggings.jpg'],
            ['name' => 'Wmn Lounge Set', 'price' => 499000, 'cat' => $cats['wmn_dresses'], 'img' => 'wmn_lounge_set.jpg'],

            // --- ACCESSORIES & STATIONERY (40 items) ---
            ['name' => 'Blu Tote Bag - Canvas', 'price' => 159000, 'cat' => $cats['acc_bags'], 'img' => 'acc_tote_canvas.jpg'],
            ['name' => 'Blu Backpack - Minimal', 'price' => 349000, 'cat' => $cats['acc_bags'], 'img' => 'acc_backpack_minimal.jpg'],
            ['name' => 'Blu Crossbody Bag', 'price' => 229000, 'cat' => $cats['acc_bags'], 'img' => 'acc_crossbody.jpg'],
            ['name' => 'Blu Belt Bag', 'price' => 189000, 'cat' => $cats['acc_bags'], 'img' => 'acc_belt_bag.jpg'],
            ['name' => 'Blu Laptop Sleeve', 'price' => 199000, 'cat' => $cats['acc_bags'], 'img' => 'acc_laptop_sleeve.jpg'],
            ['name' => 'Blu Duffle Bag', 'price' => 399000, 'cat' => $cats['acc_bags'], 'img' => 'acc_duffle.jpg'],
            ['name' => 'Blu Pouch - Mini', 'price' => 89000, 'cat' => $cats['acc_bags'], 'img' => 'acc_pouch.jpg'],
            ['name' => 'Blu Cap - Black', 'price' => 149000, 'cat' => $cats['acc_caps'], 'img' => 'acc_cap_black.jpg'],
            ['name' => 'Blu Cap - Navy', 'price' => 149000, 'cat' => $cats['acc_caps'], 'img' => 'acc_cap_navy.jpg'],
            ['name' => 'Blu Bucket Hat', 'price' => 159000, 'cat' => $cats['acc_caps'], 'img' => 'acc_bucket_hat.jpg'],
            ['name' => 'Blu Beanie - Grey', 'price' => 129000, 'cat' => $cats['acc_caps'], 'img' => 'acc_beanie.jpg'],
            ['name' => 'Blu Socks - White (3pk)', 'price' => 99000, 'cat' => $cats['acc_socks'], 'img' => 'acc_socks_white.jpg'],
            ['name' => 'Blu Socks - Black (3pk)', 'price' => 99000, 'cat' => $cats['acc_socks'], 'img' => 'acc_socks_black.jpg'],
            ['name' => 'Blu Socks - Pattern', 'price' => 89000, 'cat' => $cats['acc_socks'], 'img' => 'acc_socks_pattern.jpg'],
            ['name' => 'Blu Mug - Ceramic', 'price' => 99000, 'cat' => $cats['sta_mugs'], 'img' => 'sta_mug_ceramic.jpg'],
            ['name' => 'Blu Mug - Enamel', 'price' => 119000, 'cat' => $cats['sta_mugs'], 'img' => 'sta_mug_enamel.jpg'],
            ['name' => 'Blu Tumbler - Steel', 'price' => 159000, 'cat' => $cats['sta_mugs'], 'img' => 'sta_tumbler.jpg'],
            ['name' => 'Blu Thermos', 'price' => 199000, 'cat' => $cats['sta_mugs'], 'img' => 'sta_thermos.jpg'],
            ['name' => 'Blu Notebook - A5', 'price' => 79000, 'cat' => $cats['sta_books'], 'img' => 'sta_notebook_a5.jpg'],
            ['name' => 'Blu Planner - 2025', 'price' => 129000, 'cat' => $cats['sta_books'], 'img' => 'sta_planner.jpg'],
            ['name' => 'Blu Sketchbook', 'price' => 89000, 'cat' => $cats['sta_books'], 'img' => 'sta_sketchbook.jpg'],
            ['name' => 'Blu Gel Pens (Set)', 'price' => 69000, 'cat' => $cats['sta_books'], 'img' => 'sta_pens.jpg'], // Map tạm
            ['name' => 'Blu Mouse Pad', 'price' => 89000, 'cat' => $cats['sta_tech'], 'img' => 'sta_mousepad.jpg'],
            ['name' => 'Blu Desk Mat', 'price' => 199000, 'cat' => $cats['sta_tech'], 'img' => 'sta_deskmat.jpg'],
            ['name' => 'Blu Laptop Stand', 'price' => 299000, 'cat' => $cats['sta_tech'], 'img' => 'sta_laptopstand.jpg'],
            ['name' => 'Blu Cable Organizer', 'price' => 59000, 'cat' => $cats['sta_tech'], 'img' => 'sta_cableorg.jpg'],
            ['name' => 'Blu Sticker Pack 1', 'price' => 49000, 'cat' => $cats['sta_stickers'], 'img' => 'sta_sticker1.jpg'],
            ['name' => 'Blu Sticker Pack 2', 'price' => 49000, 'cat' => $cats['sta_stickers'], 'img' => 'sta_sticker2.jpg'],
            ['name' => 'Blu Vinyl Sticker', 'price' => 29000, 'cat' => $cats['sta_stickers'], 'img' => 'sta_vinyl.jpg'],
            ['name' => 'Blu Phone Case 13', 'price' => 99000, 'cat' => $cats['sta_tech'], 'img' => 'acc_phonecase13.jpg'],
            ['name' => 'Blu Phone Case 14', 'price' => 99000, 'cat' => $cats['sta_tech'], 'img' => 'acc_phonecase14.jpg'],
            ['name' => 'Blu Airpods Case', 'price' => 79000, 'cat' => $cats['sta_tech'], 'img' => 'acc_airpods.jpg'],
            ['name' => 'Blu Keyring', 'price' => 39000, 'cat' => $cats['acc_bags'], 'img' => 'acc_keyring.jpg'], // Map vào bags/acc
            ['name' => 'Blu Lanyard', 'price' => 49000, 'cat' => $cats['acc_bags'], 'img' => 'acc_lanyard.jpg'],
            ['name' => 'Blu Wallet - Leather', 'price' => 299000, 'cat' => $cats['acc_bags'], 'img' => 'acc_wallet.jpg'],
            ['name' => 'Blu Card Holder', 'price' => 159000, 'cat' => $cats['acc_bags'], 'img' => 'acc_cardholder.jpg'],
            ['name' => 'Blu Sunglasses', 'price' => 199000, 'cat' => $cats['acc_caps'], 'img' => 'acc_sunglasses.jpg'], // Tạm map
            ['name' => 'Blu Umbrella', 'price' => 179000, 'cat' => $cats['acc_bags'], 'img' => 'acc_umbrella.jpg'],
            ['name' => 'Blu Raincoat', 'price' => 199000, 'cat' => $cats['men_jackets'], 'img' => 'acc_raincoat.jpg'],
            ['name' => 'Blu Yoga Mat', 'price' => 359000, 'cat' => $cats['acc_bags'], 'img' => 'acc_yogamat.jpg'],
        ];

        // Chuẩn bị dữ liệu insert hàng loạt
        $data = [];
        foreach ($products as $item) {
            // Nếu không tìm thấy category ID (do lỗi seeder kia), gán random để không lỗi
            $catId = $item['cat'] ?? rand(1, 10);

            $data[] = [
                'name' => $item['name'],
                'description' => $item['name'] . ' - Thiết kế tối giản, chất lượng cao từ BluShop.',
                'price' => $item['price'],
                'image' => $item['img'],
                'category_id' => $catId,
                'is_new' => rand(0, 1),
                'is_bestseller' => rand(0, 1),
                'is_on_sale' => rand(0, 1),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Dùng chunk để insert nếu quá nhiều (ở đây 100 thì insert 1 lần cũng được)
        foreach (array_chunk($data, 50) as $chunk) {
            DB::table('products')->insert($chunk);
        }
    }
}
