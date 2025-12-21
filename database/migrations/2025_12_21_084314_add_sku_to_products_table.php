<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds the 'sku' column to the products table for unique product identification.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add SKU column - nullable to prevent errors with existing data
            // Unique constraint ensures no duplicate SKUs
            $table->string('sku')->nullable()->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('sku');
        });
    }
};
