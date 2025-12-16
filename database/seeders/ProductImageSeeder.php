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
        // 1. Dọn sạch bảng cũ
        DB::table('product_images')->truncate();

        // 2. Lấy danh sách file ảnh thật đang có trong máy
        $path = storage_path('app/public/products');

        // Check folder có tồn tại không
        if (!File::exists($path)) {
            $this->command->error("❌ Bà ơi, chưa có thư mục: $path");
            return;
        }

        // Lấy tất cả tên file ảnh (bỏ qua file hệ thống)
        $allFiles = collect(File::files($path))
            ->filter(fn($file) => in_array($file->getExtension(), ['jpg', 'jpeg', 'png', 'webp']))
            ->map(fn($file) => $file->getFilename())
            ->values();

        if ($allFiles->isEmpty()) {
            $this->command->error("❌ Trong folder không có tấm ảnh nào hết trơn á!");
            return;
        }

        // 3. Danh sách màu để random
        $colors = ['Black', 'White', 'Navy', 'Beige', 'Red', 'Blue', 'Green', 'Yellow', 'Pink', 'Grey', 'Brown', 'Purple'];

        // 4. Quẩy thôi!
        $products = Product::all();

        foreach ($products as $product) {
            // Random số lượng biến thể (0 đến 5 màu)
            // 0 màu = 1 ảnh mặc định (không chọn màu)
            $variantCount = rand(0, 5);

            // Trường hợp 1: Không có biến thể màu (Sản phẩm đơn)
            if ($variantCount === 0) {
                DB::table('product_images')->insert([
                    'product_id' => $product->id,
                    'image_path' => $allFiles->random(), // Bốc đại 1 ảnh
                    'color'      => null, // Không có màu
                    'is_main'    => 1,
                    'sort_order' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                continue;
            }

            // Trường hợp 2: Có màu (Random lấy X màu từ danh sách)
            $randomColors = collect($colors)->shuffle()->take($variantCount);

            foreach ($randomColors as $index => $color) {
                DB::table('product_images')->insert([
                    'product_id' => $product->id,
                    'image_path' => $allFiles->random(), // Bốc đại 1 ảnh khác cho màu này
                    'color'      => $color,
                    'is_main'    => ($index === 0) ? 1 : 0, // Cái đầu tiên làm ảnh chính
                    'sort_order' => $index,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info("✅ Xong! Đã random nát cái database của bà rồi đó.");
    }
}
