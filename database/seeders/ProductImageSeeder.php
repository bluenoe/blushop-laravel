<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Product;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        // --- BIỆN PHÁP MẠNH ---
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('product_images')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // -----------------------

        $path = storage_path('app/public/products');

        if (!File::exists($path)) {
            $this->command->error("❌ Bà ơi, chưa có thư mục: $path");
            return;
        }

        // ... (Giữ nguyên đoạn logic random ảnh phía dưới của bà) ...
        // Tui paste lại đoạn lấy file cho chắc ăn logic
        $allFiles = collect(File::files($path))
            ->filter(fn($file) => in_array($file->getExtension(), ['jpg', 'jpeg', 'png', 'webp']))
            ->map(fn($file) => $file->getFilename())
            ->values();

        if ($allFiles->isEmpty()) {
            $this->command->error("❌ Trong folder không có tấm ảnh nào hết trơn á!");
            return;
        }

        $colors = ['Black', 'White', 'Navy', 'Beige', 'Charcoal', 'Olive', 'Burgundy', 'Mustard', 'Taupe'];
        $products = Product::all();

        foreach ($products as $product) {
            $variantCount = rand(0, 5);

            if ($variantCount === 0) {
                DB::table('product_images')->insert([
                    'product_id' => $product->id,
                    'image_path' => $allFiles->random(),
                    'color'      => null,
                    'is_main'    => 1,
                    'sort_order' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                continue;
            }

            $randomColors = collect($colors)->shuffle()->take($variantCount);

            foreach ($randomColors as $index => $color) {
                DB::table('product_images')->insert([
                    'product_id' => $product->id,
                    'image_path' => $allFiles->random(),
                    'color'      => $color,
                    'is_main'    => ($index === 0) ? 1 : 0,
                    'sort_order' => $index,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
