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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('contact_mail')->nullable()->after('heading_font');
            $table->string('contact_no')->nullable()->after('contact_mail');
            $table->string('address')->nullable()->after('contact_no');
            $table->text('map_link')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['contact_mail', 'contact_no', 'address', 'map_link']);
        });
    }
};
