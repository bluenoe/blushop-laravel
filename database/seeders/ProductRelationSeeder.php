<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRelationSeeder extends Seeder
{
    public function run()
    {
        // 1. Xóa dữ liệu cũ trong bảng trung gian để tránh trùng lặp
        DB::table('complete_look_product')->truncate();

        // 2. Lấy tất cả id sản phẩm
        $products = Product::all();

        if ($products->count() < 5) {
            $this->command->warn("Bà cần ít nhất 5 sản phẩm trong bảng products để chạy cái này nhé!");
            return;
        }

        // 3. Lặp qua từng sản phẩm
        foreach ($products as $product) {
            // Lấy ngẫu nhiên 3 đến 4 sản phẩm KHÁC sản phẩm hiện tại
            // Logic: Random products -> Pluck ID -> Convert to Array
            $randomRelatedIds = Product::where('id', '!=', $product->id)
                ->inRandomOrder()
                ->take(rand(3, 4)) // Random lấy 3 hoặc 4 món
                ->pluck('id')
                ->toArray();

            // 4. Gắn vào bảng trung gian
            // syncWithoutDetaching: thêm vào mà không xóa cái cũ (nếu có)
            $product->completeLookProducts()->sync($randomRelatedIds);
        }

        $this->command->info('Đã tạo xong Complete The Look cho toàn bộ sản phẩm! ✅');
    }
}
