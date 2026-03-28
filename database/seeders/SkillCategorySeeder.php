<?php

namespace Database\Seeders;

use App\Models\SkillCategory;
use Illuminate\Database\Seeder;

class SkillCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Backend', 'Frontend', 'DevOps', 'Tools'];

        foreach ($categories as $category) {
            SkillCategory::create(['name' => $category]);
        }
    }
}
