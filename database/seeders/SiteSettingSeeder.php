<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SiteSetting::updateOrCreate(
            ['id' => 1],
            [
                'site_title' => 'Lavender Portfolio',
                'time_zone' => 'UTC +06:00',
                'default_font' => 'Poppins',
                'heading_font' => 'Outfit',
                'is_dark_mode' => true,
                'body_bg' => '#FFFFFF',
                'primary_color' => '#444444',
                'heading_color' => '#222222',
                'accent_color' => '#34b7a7',
                'surface_color' => '#ffffff',
                'contrast_color' => '#ffffff',
                'nav_primary' => '#444444',
                'nav_hover' => '#34b7a7',
                'nav_mobile_bg' => '#FFFFFF',
                'nav_dd_bg' => '#FFFFFF',
                'nav_dd_link' => '#444444',
                'nav_dd_hover' => '#34b7a7',
                'dark_body_bg' => '#060606',
                'dark_primary_color' => '#FFFFFF',
                'dark_heading_color' => '#FFFFFF',
                'dark_accent_color' => '#34b7a7',
                'dark_surface_color' => '#252525',
                'dark_contrast_color' => '#FFFFFF',
                'allow_indexing' => true,
                'encryption_type' => 'tls',
            ]
        );
    }
}
