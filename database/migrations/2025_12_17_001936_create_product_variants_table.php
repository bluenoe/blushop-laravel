<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            // FK liên kết với bảng products
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            // Dung tích: 30ml, 50ml, 100ml. 
            // Best practice: Lưu số (integer) để dễ sort, unit lưu riêng hoặc quy ước chung là ml.
            $table->integer('capacity_ml');

            // Giá tiền cho dung tích này (decimal cho tiền tệ là chuẩn nhất)
            $table->decimal('price', 12, 2);

            // Giá khuyến mãi (nếu có)
            $table->decimal('compare_at_price', 12, 2)->nullable();

            // Tồn kho riêng từng size
            $table->integer('stock_quantity')->default(0);

            // Mã SKU riêng (VD: CHANEL-N5-50ML) -> Quan trọng để quản lý kho
            $table->string('sku')->unique();

            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexing để query nhanh khi user filter size
            $table->index(['product_id', 'capacity_ml']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
