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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();

            // Liên kết với bảng products
            $table->unsignedBigInteger('product_id');

            // Đường dẫn ảnh
            $table->string('image_path');

            // Màu sắc (Ví dụ: "Black", "Navy", "#000000"). 
            // Để nullable vì có thể có ảnh chụp chi tiết không phân màu.
            $table->string('color')->nullable();

            // Đánh dấu ảnh này có phải ảnh chính (thumbnail) của màu đó không
            $table->boolean('is_main')->default(false);

            // Thứ tự hiển thị (nếu bà muốn sắp xếp ảnh nào trước ảnh nào sau)
            $table->integer('sort_order')->default(0);

            $table->timestamps();

            // Khóa ngoại: Nếu xóa Product thì xóa luôn ảnh của nó (Cascade)
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
