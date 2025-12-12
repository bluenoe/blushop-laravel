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
        Schema::table('reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('reviews', 'content')) {
                $table->text('content')->nullable()->after('rating');
            }
        });
    }



    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('content');
        });
    }
};
