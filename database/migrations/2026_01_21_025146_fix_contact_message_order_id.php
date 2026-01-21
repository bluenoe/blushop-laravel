<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. Tạo cột tạm thời để hứng dữ liệu sạch
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id_new')->nullable()->after('order_id');
        });

        // 2. DATA MIGRATION (Lọc và rửa dữ liệu)
        // Lấy danh sách ID đơn hàng có thật để so sánh cho nhanh
        $validOrderIds = DB::table('orders')->pluck('id')->toArray();

        // Lấy tất cả tin nhắn có order_id
        $messages = DB::table('contact_messages')
                    ->whereNotNull('order_id')
                    ->where('order_id', '!=', '')
                    ->get();

        foreach ($messages as $msg) {
            // Logic: Chỉ convert nếu nó là số VÀ nó có tồn tại trong bảng orders
            // Ví dụ: user nhập "123" (ok), user nhập "#123" (bỏ), user nhập "abc" (bỏ)
            if (is_numeric($msg->order_id) && in_array((int)$msg->order_id, $validOrderIds)) {
                DB::table('contact_messages')
                    ->where('id', $msg->id)
                    ->update(['order_id_new' => (int)$msg->order_id]);
            }
        }

        // 3. Xóa cũ, rename mới
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn('order_id'); // Xóa cột rác cũ
        });

        Schema::table('contact_messages', function (Blueprint $table) {
            // Đổi tên cột mới thành tên chính thức 'order_id'
            $table->renameColumn('order_id_new', 'order_id');
        });

        // 4. Khóa lại bằng Foreign Key
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
        });
    }

    public function down()
    {
        // Rollback: Xóa FK, xóa cột bigint, tạo lại cột varchar
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropForeign(['contact_messages_order_id_foreign']);
            // Lưu ý: data rollback sẽ mất độ chính xác (biến hết thành string)
            $table->string('order_id_temp', 50)->nullable();
        });
        
        DB::statement('UPDATE contact_messages SET order_id_temp = CAST(order_id AS CHAR)');
        
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn('order_id');
            $table->renameColumn('order_id_temp', 'order_id');
        });
    }
};