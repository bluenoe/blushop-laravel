<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $roots = [
            'Men' => ['Tops', 'Bottoms', 'Outerwear', 'Activewear'],
            'Women' => ['Dresses', 'Tops', 'Bottoms', 'Outerwear'],
            'Fragrance' => ['For Him', 'For Her', 'Unisex'],
        ];

        foreach ($roots as $rootName => $children) {
            $parent = Category::updateOrCreate(
                ['slug' => Str::slug($rootName)],
                ['name' => $rootName, 'parent_id' => null]
            );

            foreach ($children as $childName) {
                Category::updateOrCreate(
                    ['slug' => Str::slug($rootName . ' ' . $childName)],
                    ['name' => $childName, 'parent_id' => $parent->id]
                );
            }
        }
    }
}
