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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // Link với User (người đánh giá)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Link với Product (sản phẩm được đánh giá)
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->integer('rating')->default(5); // Số sao (1-5)

            $table->text('content')->nullable(); // Nội dung review

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
