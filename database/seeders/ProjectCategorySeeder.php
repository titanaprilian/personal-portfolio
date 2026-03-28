<?php

namespace Database\Seeders;

use App\Models\ProjectCategory;
use Illuminate\Database\Seeder;

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
            ProjectCategory::create(['name' => $category]);
        }
    }
}
