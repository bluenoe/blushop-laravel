<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds 'stock' and 'is_on_sale' columns to the products table.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add stock column - default 0 for inventory tracking
            if (!Schema::hasColumn('products', 'stock')) {
                $table->integer('stock')->default(0)->after('base_price');
            }
            
            // Add is_on_sale boolean flag - default false
            if (!Schema::hasColumn('products', 'is_on_sale')) {
                $table->boolean('is_on_sale')->default(false)->after('stock');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'stock')) {
                $table->dropColumn('stock');
            }
            if (Schema::hasColumn('products', 'is_on_sale')) {
                $table->dropColumn('is_on_sale');
            }
        });
    }
};
