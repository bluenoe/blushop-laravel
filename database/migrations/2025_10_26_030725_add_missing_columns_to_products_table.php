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
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'name')) {
                $table->string('name')->after('id');
            }
            if (! Schema::hasColumn('products', 'price')) {
                $table->decimal('price', 10, 2)->default(0);
            }
            if (! Schema::hasColumn('products', 'image')) {
                $table->string('image')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'image')) {
                $table->dropColumn('image');
            }
            if (Schema::hasColumn('products', 'price')) {
                $table->dropColumn('price');
            }
            if (Schema::hasColumn('products', 'name')) {
                $table->dropColumn('name');
            }
        });
    }
};
