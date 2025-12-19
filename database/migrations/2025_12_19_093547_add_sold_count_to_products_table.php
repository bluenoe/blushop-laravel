<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Thêm cột đếm số lượng đã bán, mặc định là 0
            // Đặt sau cột price cho dễ nhìn trong DB
            $table->unsignedBigInteger('sold_count')->default(0)->after('price');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('sold_count');
        });
    }
};
