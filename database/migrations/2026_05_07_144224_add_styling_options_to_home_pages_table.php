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
        Schema::table('home_pages', function (Blueprint $table) {
            $table->string('title_size')->nullable();
            $table->string('title_color')->nullable();
            $table->string('title_font')->nullable();
            $table->string('subtitle_size')->nullable();
            $table->string('subtitle_color')->nullable();
            $table->string('subtitle_font')->nullable();
            $table->string('btn_theme')->default('accent');
            $table->boolean('btn_outline')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_pages', function (Blueprint $table) {
            $table->dropColumn([
                'title_size', 'title_color', 'title_font',
                'subtitle_size', 'subtitle_color', 'subtitle_font',
                'btn_theme', 'btn_outline'
            ]);
        });
    }
};
