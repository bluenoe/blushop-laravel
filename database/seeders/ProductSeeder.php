<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Dùng 2–3 ảnh mẫu để reuse cho 8 sản phẩm
        $images = ['sample1.jpg', 'sample2.jpg', 'sample3.jpg'];

        $items = [
            [
                'name' => 'Blu T-Shirt',
                'description' => 'Áo thun chất liệu cotton 100%, thoáng mát, logo Blu tối giản.',
                'price' => 199000,
            ],
            [
                'name' => 'Blu Hoodie',
                'description' => 'Hoodie nỉ ấm, form rộng, đi học đi chơi đều xịn.',
                'price' => 399000,
            ],
            [
                'name' => 'Blu Cap',
                'description' => 'Nón lưỡi trai basic, phối đồ dễ, chống nắng ổn.',
                'price' => 149000,
            ],
            [
                'name' => 'Blu Mug',
                'description' => 'Ly sứ in logo Blu, giữ nhiệt tương đối, vibe học bài chill.',
                'price' => 99000,
            ],
            [
                'name' => 'Blu Tote Bag',
                'description' => 'Túi tote canvas bền, đựng laptop mỏng, sách vở thoải mái.',
                'price' => 159000,
            ],
            [
                'name' => 'Blu Mouse Pad',
                'description' => 'Lót chuột bề mặt mịn, trơn, cỡ vừa cho góc học tập.',
                'price' => 89000,
            ],
            [
                'name' => 'Blu Sticker Pack',
                'description' => 'Bộ sticker vinyl chống nước, dán laptop, bình nước.',
                'price' => 49000,
            ],
            [
                'name' => 'Blu Notebook',
                'description' => 'Sổ tay giấy dày, không lem mực, bìa tối giản.',
                'price' => 79000,
            ],
        ];

        $now = now();

        $data = array_map(function ($item) use ($images, $now) {
            return [
                'name' => $item['name'],
                'description' => $item['description'],
                'price' => $item['price'],
                'image' => $images[array_rand($images)],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $items);

        DB::table('products')->insert($data);
    }
}
