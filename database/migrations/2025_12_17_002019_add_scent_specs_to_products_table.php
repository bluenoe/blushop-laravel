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
            // Lưu cấu trúc tầng hương, độ lưu hương...
            // Tại sao JSON? Vì nó linh hoạt, không cần join nhiều bảng phức tạp cho việc HIỂN THỊ.
            $table->json('specifications')->nullable()->after('description');

            // Thêm cột này để filter nhanh nhóm hương (Gỗ, Hoa, Biển...)
            $table->string('scent_family')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
