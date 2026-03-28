<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Illuminate\Database\Seeder;

class PostCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'PHP',
            'Node JS',
            'Bun',
            'Machine Learning',
            'Tools & Workflow',
            'System Design',
        ];

        foreach ($categories as $category) {
            PostCategory::create(['name' => $category]);
        }
    }
}
