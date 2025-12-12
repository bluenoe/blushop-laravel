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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('rating'); // 1 đến 5 sao
            // Fit rating: 1 (Chật), 2 (Hơi chật), 3 (Vừa in), 4 (Hơi rộng), 5 (Rộng)
            $table->integer('fit_rating')->default(3);
            $table->text('comment')->nullable();
            $table->string('image')->nullable(); // Đường dẫn ảnh review
            $table->boolean('is_approved')->default(true); // Tự động hiện hoặc cần duyệt
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
