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
        // --- BIỆN PHÁP MẠNH: Dùng SQL thuần để tắt check khóa ngoại ---
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // -------------------------------------------------------------

        $now = Carbon::now();

        // 1. Tạo Danh Mục CHA (Root)
        $roots = [
            'Men' => ['Tops', 'Bottoms', 'Outerwear', 'Activewear'],
            'Women' => ['Dresses', 'Tops', 'Bottoms', 'Outerwear'],
            'Fragrance' => ['For Him', 'For Her', 'Unisex']
        ];

        foreach ($roots as $rootName => $children) {
            $parentId = DB::table('categories')->insertGetId([
                'name' => $rootName,
                'slug' => Str::slug($rootName),
                'parent_id' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            foreach ($children as $childName) {
                DB::table('categories')->insert([
                    'name' => $childName,
                    'slug' => Str::slug($rootName . ' ' . $childName),
                    'parent_id' => $parentId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
