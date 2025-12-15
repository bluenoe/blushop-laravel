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
            $table->string('type')->default('apparel')->after('category_id')->index(); // apparel, accessories, electronics
            $table->json('specifications')->nullable()->after('description');
            $table->json('options')->nullable()->after('specifications'); // colors, sizes, etc.
            $table->text('care_guide')->nullable()->after('options');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['type', 'specifications', 'options', 'care_guide']);
        });
    }
};
