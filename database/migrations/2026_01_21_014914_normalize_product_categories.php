<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. Thêm cột category_id mới (tạm thời cho null)
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('id');
        });

        // 2. DI TRÚ DỮ LIỆU (Mapping data cũ sang mới)
        // Lấy ID của các danh mục (Đảm bảo trong bảng categories đã có data nhé)
        $cats = DB::table('categories')->pluck('id', 'slug'); // Trả về mảng ['men' => 1, 'women' => 2...]

        // Cập nhật từng dòng sản phẩm
        foreach ($cats as $slug => $id) {
            DB::table('products')
                ->where('category', $slug) // Cột 'category' cũ (enum)
                ->update(['category_id' => $id]);
        }

        // 3. Xóa cột cũ và khóa cột mới
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('category'); // Bái bai cột Enum cũ

            // Sửa cột category_id thành bắt buộc (not null) và thêm khóa ngoại
            // Lưu ý: Nếu có sản phẩm nào chưa có category, lệnh này sẽ lỗi. 
            // Bà nên check DB trước hoặc để nullable nếu muốn an toàn tuyệt đối.
            $table->unsignedBigInteger('category_id')->nullable(false)->change(); 
            
            // Tạo dây nối (Foreign Key)
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        // Logic quay xe (Rollback) nếu chạy lỗi
        Schema::table('products', function (Blueprint $table) {
            $table->enum('category', ['men', 'women', 'fragrance'])->nullable();
            $table->dropForeign(['products_category_id_foreign']);
            $table->dropColumn('category_id');
        });
    }
};

