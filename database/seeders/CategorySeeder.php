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
        // Xóa sạch bảng cũ (phòng hờ)
        DB::table('categories')->truncate();

        $now = Carbon::now();

        // CẤU TRÚC MỚI: CHUẨN FASHION & LIFESTYLE
        $roots = [
            'Men' => [
                'Tops',        // Áo
                'Bottoms',     // Quần
                'Outerwear',   // Áo khoác
                'Activewear'   // Đồ thể thao
            ],
            'Women' => [
                'Dresses',     // Váy liền
                'Tops',        // Áo
                'Bottoms',     // Quần/Váy ngắn
                'Outerwear',   // Áo khoác
            ],
            'Fragrance' => [   // DANH MỤC MỚI
                'For Him',
                'For Her',
                'Unisex'
            ]
        ];

        foreach ($roots as $rootName => $children) {
            // Tạo cha
            $parentId = DB::table('categories')->insertGetId([
                'name' => $rootName,
                'slug' => Str::slug($rootName),
                'parent_id' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Tạo con
            foreach ($children as $childName) {
                // Slug: men-tops, women-dresses, fragrance-unisex
                $childSlug = Str::slug($rootName . ' ' . $childName);

                DB::table('categories')->insert([
                    'name' => $childName,
                    'slug' => $childSlug,
                    'parent_id' => $parentId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
