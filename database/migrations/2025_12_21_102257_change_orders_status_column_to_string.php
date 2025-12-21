<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Change status column from ENUM to VARCHAR(50) for flexibility.
     */
    public function up(): void
    {
        // Use raw SQL to change ENUM to VARCHAR (doctrine/dbal has issues with ENUM)
        DB::statement("ALTER TABLE orders MODIFY COLUMN status VARCHAR(50) DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to ENUM if needed (adjust values as per original schema)
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending'");
    }
};
