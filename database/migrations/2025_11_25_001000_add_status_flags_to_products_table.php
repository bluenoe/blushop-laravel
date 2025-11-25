<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'is_new')) {
                $table->boolean('is_new')->default(false)->after('category_id');
            }
            if (! Schema::hasColumn('products', 'is_bestseller')) {
                $table->boolean('is_bestseller')->default(false)->after('is_new');
            }
            if (! Schema::hasColumn('products', 'is_on_sale')) {
                $table->boolean('is_on_sale')->default(false)->after('is_bestseller');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'is_on_sale')) {
                $table->dropColumn('is_on_sale');
            }
            if (Schema::hasColumn('products', 'is_bestseller')) {
                $table->dropColumn('is_bestseller');
            }
            if (Schema::hasColumn('products', 'is_new')) {
                $table->dropColumn('is_new');
            }
        });
    }
};

