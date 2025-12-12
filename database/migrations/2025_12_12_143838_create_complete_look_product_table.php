<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complete_look_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('look_product_id');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('look_product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unique(['product_id', 'look_product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complete_look_product');
    }
};
