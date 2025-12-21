<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds 'original_price' column for "On Sale" feature - shows the "before discount" price.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Original/Retail price - shown as struck-through when on sale
            // Nullable because not all products have a discount
            $table->integer('original_price')->nullable()->after('base_price');
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
    }
};
