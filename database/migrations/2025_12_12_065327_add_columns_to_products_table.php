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
        Schema::table('products', function (Blueprint $table) {
            // Lưu các thông số kỹ thuật dạng Key-Value: {"Gót": "9cm", "Chất liệu": "Da bò"}
            //$table->json('specifications')->nullable();

            // Hướng dẫn bảo quản (Text dài)
            //$table->text('care_guide')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
