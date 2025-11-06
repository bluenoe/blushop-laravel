<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $items = [
            [
                'name' => 'Blu Water Bottle',
                'description' => 'Bình nước Blu chất liệu inox 304 cao cấp, giữ nhiệt tốt, thiết kế logo Blu tối giản, tiện mang đi học, đi làm, hoặc tập gym.',
                'price' => 129000,
                'image' => 'blu_water_bottle.jpg',
            ],
            [
                'name' => 'Blu Phone Case',
                'description' => 'Ốp điện thoại Blu dẻo nhẹ, bảo vệ tốt, in logo Blu tinh tế, phù hợp với nhiều dòng máy phổ biến.',
                'price' => 99000,
                'image' => 'blu_phone_case.jpg',
            ],
            [
                'name' => 'Blu Pencil Case',
                'description' => 'Hộp bút Blu vải canvas bền, gọn nhẹ, nhiều ngăn tiện lợi, tông xanh đặc trưng của Blu.',
                'price' => 69000,
                'image' => 'blu_pencil_case.jpg',
            ],
            [
                'name' => 'Blu Umbrella',
                'description' => 'Dù Blu gấp gọn, khung thép chống gió, lớp phủ chống UV, tay cầm in logo Blu.',
                'price' => 179000,
                'image' => 'blu_umbrella.jpg',
            ],
            [
                'name' => 'Blu Blanket',
                'description' => 'Chăn Blu siêu mềm, chất vải nỉ mịn, ấm áp, họa tiết logo Blu nhẹ nhàng cho không gian thư giãn.',
                'price' => 299000,
                'image' => 'blu_blanket.jpg',
            ],
            [
                'name' => 'Blu Backpack',
                'description' => 'Balo Blu chống nước, ngăn laptop riêng biệt, form đẹp, phối màu hiện đại, logo Blu nổi bật.',
                'price' => 349000,
                'image' => 'blu_backpack.jpg',
            ],
            [
                'name' => 'Blu Candle',
                'description' => 'Nến thơm Blu hương lavender dễ chịu, lọ thủy tinh sang trọng, thắp sáng không gian học tập và làm việc.',
                'price' => 159000,
                'image' => 'blu_candle.jpg',
            ],
            [
                'name' => 'Blu Keychain',
                'description' => 'Móc khóa Blu mini dễ thương, chất liệu cao su dẻo, in nổi logo Blu, phụ kiện nhỏ xinh cho balo và chìa khóa.',
                'price' => 39000,
                'image' => 'blu_keychain.jpg',
            ],
            [
                'name' => 'Blu Socks',
                'description' => 'Vớ Blu cotton thoáng khí, thấm hút tốt, phối màu xanh - trắng nhẹ nhàng, thoải mái cả ngày.',
                'price' => 89000,
                'image' => 'blu_socks.jpg',
            ],
            [
                'name' => 'Blu Wireless Charger',
                'description' => 'Sạc không dây Blu tốc độ cao, tương thích iPhone và Android, thiết kế tròn nhỏ gọn, đèn LED tinh tế.',
                'price' => 259000,
                'image' => 'blu_wireless_charger.jpg',
            ],
        ];

        $data = array_map(fn($item) => [
            'name' => $item['name'],
            'description' => $item['description'],
            'price' => $item['price'],
            'image' => $item['image'],
            'created_at' => $now,
            'updated_at' => $now,
        ], $items);

        DB::table('products')->insert($data);
    }
}
