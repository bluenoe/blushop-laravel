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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Cột JSON chứa thông số kỹ thuật (thay cho file add_specs cũ)
            $table->json('specifications')->nullable();

            $table->enum('category', ['men', 'women', 'fragrance']);
            $table->decimal('base_price', 12, 2);

            // Các cột trạng thái (thay cho file add_status cũ)
            $table->boolean('is_active')->default(true);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_bestseller')->default(false);

            // Các cột Review (thay cho file add_review_stats cũ)
            $table->decimal('avg_rating', 3, 2)->default(0);
            $table->integer('reviews_count')->default(0);

            $table->integer('sold_count')->default(0);

            $table->softDeletes(); // Thay cho file add_soft_deletes cũ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
