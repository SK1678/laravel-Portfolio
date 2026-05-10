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
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->unsignedBigInteger('reply_to_id')->nullable()->after('receiver_id');
            $table->string('attachment', 255)->nullable()->after('message');
            $table->string('file_type', 50)->nullable()->after('attachment');
            $table->string('file_name', 255)->nullable()->after('file_type');
            
            $table->foreign('reply_to_id')->references('id')->on('chat_messages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropForeign(['reply_to_id']);
            $table->dropColumn(['reply_to_id', 'attachment', 'file_type', 'file_name']);
        });
    }
};
