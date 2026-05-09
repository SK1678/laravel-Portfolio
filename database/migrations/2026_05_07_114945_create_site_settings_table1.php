<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();

            // General Settings
            $table->string('site_title')->default('Lavender Portfolio');
            $table->string('favicon')->nullable();
            $table->string('time_zone')->default('UTC +06:00');
            $table->string('default_font')->default('Poppins');
            $table->string('heading_font')->default('Outfit');

            // Global Colors
            $table->string('body_bg')->default('#FFFFFF');
            $table->string('primary_color')->default('#444444');
            $table->string('heading_color')->default('#222222');
            $table->string('accent_color')->default('#34b7a7');
            $table->string('surface_color')->default('#ffffff');
            $table->string('contrast_color')->default('#ffffff');

            // Nav Menu Colors
            $table->string('nav_primary')->default('#444444');
            $table->string('nav_hover')->default('#34b7a7');
            $table->string('nav_mobile_bg')->default('#FFFFFF');
            $table->string('nav_dd_bg')->default('#FFFFFF');
            $table->string('nav_dd_link')->default('#444444');
            $table->string('nav_dd_hover')->default('#34b7a7');

            // Dark Mode
            $table->boolean('is_dark_mode')->default(true);
            $table->string('dark_body_bg')->default('#060606');
            $table->string('dark_primary_color')->default('#FFFFFF');
            $table->string('dark_heading_color')->default('#FFFFFF');
            $table->string('dark_accent_color')->default('#34b7a7');
            $table->string('dark_surface_color')->default('#252525');
            $table->string('dark_contrast_color')->default('#FFFFFF');

            // SEO Settings
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('google_analytics_id')->nullable();
            $table->boolean('allow_indexing')->default(true);

            // Email Server Settings
            $table->string('smtp_host')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('encryption_type')->default('tls');
            $table->string('smtp_username')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('sender_name')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
