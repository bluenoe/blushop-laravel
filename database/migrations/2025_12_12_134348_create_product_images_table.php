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
            // Liên kết với bảng products, xóa product thì xóa luôn ảnh
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            // Cột chứa đường dẫn ảnh
            $table->string('url');

            // Nếu cần sắp xếp thứ tự ảnh
            $table->integer('sort_order')->default(0);

            $table->timestamps();
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
