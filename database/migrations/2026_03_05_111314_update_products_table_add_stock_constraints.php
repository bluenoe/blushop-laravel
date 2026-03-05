<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Add a CHECK constraint to ensure stock can never go negative.
     * This provides database-level protection against overselling,
     * even if application logic fails.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE products ADD CONSTRAINT chk_stock_non_negative CHECK (stock >= 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE products DROP CONSTRAINT chk_stock_non_negative');
    }
};
