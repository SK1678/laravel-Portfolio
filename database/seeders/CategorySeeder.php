<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::updateOrCreate(['slug' => 'blog'], [
            'name' => 'Blog',
            'is_protected' => true,
            'parent_id' => null
        ]);

        Category::updateOrCreate(['slug' => 'portfolio'], [
            'name' => 'Portfolio',
            'is_protected' => true,
            'parent_id' => null
        ]);
    }
}
