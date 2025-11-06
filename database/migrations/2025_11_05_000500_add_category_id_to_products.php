<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1) Add nullable category_id with index + FK
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable()->after('image');
                $table->index('category_id');
                $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('restrict');
            }
        });

        // 2) Ensure default 'Uncategorized' exists
        $uncat = DB::table('categories')->where('slug', 'uncategorized')->first();
        if (!$uncat) {
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

        // 4) Make category_id NOT NULL (driver-specific)
        $driver = DB::getDriverName();
        try {
            if ($driver === 'mysql') {
                DB::statement('ALTER TABLE products MODIFY category_id BIGINT UNSIGNED NOT NULL');
            } elseif ($driver === 'pgsql') {
                DB::statement('ALTER TABLE products ALTER COLUMN category_id SET NOT NULL');
            } elseif ($driver === 'sqlite') {
                // SQLite ALTER COLUMN not supported; leave as nullable but enforced at app level
                // Optional: a CHECK constraint could be added via table rebuild; skipping for simplicity
            }
        } catch (\Throwable $e) {
            // If changing column fails, leave nullable (app-level validation will enforce)
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'category_id')) {
                // Drop FK first then column
                try {
                    $table->dropForeign(['category_id']);
                } catch (\Throwable $e) {}
                try {
                    $table->dropIndex(['category_id']);
                } catch (\Throwable $e) {}
                $table->dropColumn('category_id');
            }
        });
    }
};