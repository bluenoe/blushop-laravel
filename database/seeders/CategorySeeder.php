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
        $names = [
            'T-Shirts',
            'Hoodies',
            'Accessories',
            'Mugs',
            'Stickers',
            'Bags',
            'Caps',
            'Stationery',
        ];

        foreach ($names as $name) {
            $slug = Str::slug($name);
            $exists = DB::table('categories')->where('slug', $slug)->exists();
            if (! $exists) {
                DB::table('categories')->insert([
                    'name' => $name,
                    'slug' => $slug,
                    'description' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
