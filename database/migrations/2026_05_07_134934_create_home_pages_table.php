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
        Schema::create('home_pages', function (Blueprint $table) {
            $table->id();
            $table->enum('mode', ['single', 'slider', 'video'])->default('single');
            $table->json('images')->nullable(); // For single image or slider images
            $table->string('video_url')->nullable();
            $table->json('buttons')->nullable(); // Array of ['label' => ..., 'link' => ...]
            $table->boolean('show_cv_button')->default(true);
            $table->string('cv_button_label')->default('Download CV');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_pages');
    }
};
