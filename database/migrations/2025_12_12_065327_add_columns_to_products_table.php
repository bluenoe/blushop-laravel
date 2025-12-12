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
            // Only add the column if it doesn't exist
            if (!Schema::hasColumn('products', 'specifications')) {
                $table->json('specifications')->nullable();
            }

            // Hướng dẫn bảo quản (Text dài)
            //$table->text('care_guide')->nullable();
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
