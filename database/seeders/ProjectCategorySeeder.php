<?php

namespace Database\Seeders;

use App\Models\ProjectCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Web App',
            'API',
            'DevOps',
            'Machine Learning',
        ];

        foreach ($categories as $category) {
            ProjectCategory::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }
    }
}
