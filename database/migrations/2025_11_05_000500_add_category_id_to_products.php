<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Add nullable category_id with index + FK
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable()->after('image');
                $table->index('category_id');
                $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
                    ->onUpdate('cascade')
                    ->onDelete('set null'); // ✅ đổi restrict -> set null để an toàn
            }
        });

        // 2) Ensure default 'Uncategorized' exists
        $uncat = DB::table('categories')->where('slug', 'uncategorized')->first();
        if (! $uncat) {
            $uncatId = DB::table('categories')->insertGetId([
                'name' => 'Uncategorized',
                'slug' => 'uncategorized',
                'description' => 'Default catch-all category for products not assigned yet.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $uncatId = $uncat->id;
        }

        // 3) Backfill existing products to 'Uncategorized'
        DB::table('products')->whereNull('category_id')->update(['category_id' => $uncatId]);

        // ⚠️ 4) Remove the NOT NULL enforcement for now
        // Because ProductSeeder inserts products without category_id yet.
        // We'll keep nullable and enforce in code level later.
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'category_id')) {
                try {
                    $table->dropForeign(['category_id']);
                } catch (\Throwable $e) {
                }
                try {
                    $table->dropIndex(['category_id']);
                } catch (\Throwable $e) {
                }
                $table->dropColumn('category_id');
            }
        });
    }
};
