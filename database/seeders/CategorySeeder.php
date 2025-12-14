<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Tạo Danh Mục CHA (Root)
        $roots = [
            'Men' => [
                'T-Shirts',
                'Hoodies',
                'Jackets',
                'Pants',
                'Shorts'
            ],
            'Women' => [
                'T-Shirts',
                'Dresses',
                'Skirts',
                'Blouses',
                'Cardigans'
            ],
            'Accessories' => [
                'Bags',
                'Caps',
                'Socks',
                'Jewelry',
                'Watches'
            ],
            'Stationery' => [
                'Mugs',
                'Notebooks',
                'Pens',
                'Stickers',
                'Tech'
            ]
        ];

        foreach ($roots as $rootName => $children) {
            // Tạo cha
            $parentId = DB::table('categories')->insertGetId([
                'name' => $rootName,
                'slug' => Str::slug($rootName), // vd: men
                'parent_id' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Tạo con
            foreach ($children as $childName) {
                // Tạo slug riêng biệt: men-t-shirts vs women-t-shirts
                $childSlug = Str::slug($rootName . ' ' . $childName);

                DB::table('categories')->insert([
                    'name' => $childName, // Tên hiển thị vẫn là "T-Shirts"
                    'slug' => $childSlug, // Slug thì là "men-t-shirts"
                    'parent_id' => $parentId, // Gắn vào cha
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
