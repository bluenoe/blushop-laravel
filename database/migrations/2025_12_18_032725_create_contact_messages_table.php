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
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->index(); // Index để sau này tìm kiếm/filter nhanh hơn
            $table->string('topic')->nullable();
            $table->string('order_id')->nullable(); // Có thể để string nếu order ID có ký tự chữ
            $table->text('message'); // Dùng text vì message có thể dài
            $table->string('status')->default('new'); // Best practice: Thêm trạng thái xử lý (new, read, replied)
            $table->ipAddress('ip_address')->nullable(); // Nên lưu IP để chặn spam nếu cần
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
