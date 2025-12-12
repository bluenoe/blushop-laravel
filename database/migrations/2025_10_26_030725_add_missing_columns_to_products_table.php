<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'name')) {
                $table->string('name')->after('id');
            }

            if (!Schema::hasColumn('products', 'price')) {
                $table->decimal('price', 10, 2)->default(0);
            }

            if (!Schema::hasColumn('products', 'image')) {
                $table->string('image')->nullable();
            }

            if (!Schema::hasColumn('products', 'specifications')) {
                $table->json('specifications')->nullable();
            }

            if (!Schema::hasColumn('products', 'care_guide')) {
                $table->text('care_guide')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            foreach (['care_guide', 'specifications', 'image', 'price', 'name'] as $col) {
                if (Schema::hasColumn('products', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
