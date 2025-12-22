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
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->string('topic', 100)->nullable()->after('email');
            $table->string('order_id', 50)->nullable()->after('topic');
            $table->string('ip_address', 45)->nullable()->after('message');
            $table->string('status', 20)->default('new')->after('ip_address');
            $table->timestamp('updated_at')->nullable()->after('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn(['topic', 'order_id', 'ip_address', 'status', 'updated_at']);
        });
    }
};
