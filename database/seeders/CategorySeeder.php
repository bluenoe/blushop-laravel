<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // 1. Định nghĩa Danh mục Cha (Root)
        $roots = ['Men', 'Women', 'Accessories', 'Stationery'];

        $rootIds = [];
        foreach ($roots as $root) {
            $slug = Str::slug($root);
            // Kiểm tra hoặc tạo mới
            $id = DB::table('categories')->where('slug', $slug)->value('id');
            if (!$id) {
                $id = DB::table('categories')->insertGetId([
                    'name' => $root,
                    'slug' => $slug,
                    'parent_id' => null, // Cha thì không có parent_id
                    'description' => "Danh mục chính $root",
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            }
            $rootIds[$root] = $id;
        }

        // 2. Định nghĩa Danh mục Con (Children)
        // Cấu trúc: 'Tên Cha' => ['Con 1', 'Con 2'...]
        $tree = [
            'Men' => ['T-Shirts', 'Hoodies', 'Jackets', 'Pants', 'Shorts'],
            'Women' => ['T-Shirts', 'Dresses', 'Skirts', 'Blouses', 'Cardigans'],
            'Accessories' => ['Bags', 'Caps', 'Socks', 'Jewelry', 'Watches'],
            'Stationery' => ['Mugs', 'Notebooks', 'Pens', 'Stickers', 'Tech'],
        ];

        foreach ($tree as $rootName => $children) {
            $parentId = $rootIds[$rootName];

            foreach ($children as $childName) {
                // Tạo slug kết hợp để tránh trùng (vd: men-t-shirts vs women-t-shirts)
                $slug = Str::slug($rootName . ' ' . $childName);

                $exists = DB::table('categories')->where('slug', $slug)->exists();
                if (!$exists) {
                    DB::table('categories')->insert([
                        'name' => $childName,
                        'slug' => $slug, // Slug là duy nhất
                        'parent_id' => $parentId, // Gắn vào cha
                        'description' => "$childName dành cho $rootName",
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                }
            }
        }
    }
}
