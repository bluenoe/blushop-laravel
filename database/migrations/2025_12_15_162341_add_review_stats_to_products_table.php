<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Thêm cột avg_rating (số thập phân, ví dụ 4.5)
            // default(0) để sản phẩm cũ không bị lỗi
            $table->decimal('avg_rating', 3, 2)->default(0)->after('price');

            // Thêm cột reviews_count (số nguyên)
            $table->integer('reviews_count')->default(0)->after('avg_rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Nếu rollback thì xóa 2 cột này đi
            $table->dropColumn(['avg_rating', 'reviews_count']);
        });
    }
};
