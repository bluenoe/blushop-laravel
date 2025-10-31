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
                'name' => 'Blu T-Shirt',
                'description' => 'Áo thun chất liệu cotton 100%, thoáng mát, logo Blu tối giản.',
                'price' => 199000,
                'image' => 'blu_tshirt.jpg',
            ],
            [
                'name' => 'Blu Hoodie',
                'description' => 'Hoodie nỉ ấm, form rộng, đi học đi chơi đều xịn.',
                'price' => 399000,
                'image' => 'blu_hoodie.jpg',
            ],
            [
                'name' => 'Blu Cap',
                'description' => 'Nón lưỡi trai basic, phối đồ dễ, chống nắng ổn.',
                'price' => 149000,
                'image' => 'blu_cap.jpg',
            ],
            [
                'name' => 'Blu Mug',
                'description' => 'Ly sứ in logo Blu, giữ nhiệt tương đối, vibe học bài chill.',
                'price' => 99000,
                'image' => 'blu_mug.jpg',
            ],
            [
                'name' => 'Blu Tote Bag',
                'description' => 'Túi tote canvas bền, đựng laptop mỏng, sách vở thoải mái.',
                'price' => 159000,
                'image' => 'blu_totebag.jpg',
            ],
            [
                'name' => 'Blu Mouse Pad',
                'description' => 'Lót chuột bề mặt mịn, trơn, cỡ vừa cho góc học tập.',
                'price' => 89000,
                'image' => 'blu_mousepad.jpg',
            ],
            [
                'name' => 'Blu Sticker Pack',
                'description' => 'Bộ sticker vinyl chống nước, dán laptop, bình nước.',
                'price' => 49000,
                'image' => 'blu_stickerpack.jpg',
            ],
            [
                'name' => 'Blu Notebook',
                'description' => 'Sổ tay giấy dày, không lem mực, bìa tối giản.',
                'price' => 79000,
                'image' => 'blu_notebook.jpg',
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
