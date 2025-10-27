<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('price_vnd')->nullable()->after('price'); // giữ cột float price cũ (deprecate)
            $table->index('name');
        });

        // Data migration: copy từ price(float) sang price_vnd(int)
        DB::table('products')->select('id', 'price')->orderBy('id')->chunk(200, function ($rows) {
            foreach ($rows as $r) {
                $vnd = is_null($r->price) ? 0 : (int)round($r->price);
                DB::table('products')->where('id', $r->id)->update(['price_vnd' => $vnd]);
            }
        });

        // Set NOT NULL sau khi copy xong
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('price_vnd')->nullable(false)->change();
        });
    }

    public function down(): void {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropColumn('price_vnd');
        });
    }
};
