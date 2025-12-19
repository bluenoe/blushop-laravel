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
        // Add original_price to products
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('original_price', 10, 2)->nullable()->after('price');
        });

        // Add color_name and hex_code to product_variants
        Schema::table('product_variants', function (Blueprint $table) {
            $table->string('color_name')->nullable()->after('sku');
            $table->string('hex_code')->nullable()->after('color_name'); // e.g. #FF0000
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('original_price');
        });

        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn(['color_name', 'hex_code']);
        });
    }
};
