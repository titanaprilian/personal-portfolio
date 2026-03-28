<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $categories = SkillCategory::pluck('id', 'name')->toArray();

        $skills = [
            ['name' => 'Laravel', 'category' => 'Fullstack'],
            ['name' => 'Next.js', 'category' => 'Fullstack'],
            ['name' => 'React', 'category' => 'Frontend'],
            ['name' => 'Docker', 'category' => 'DevOps'],
            ['name' => 'Linux', 'category' => 'Tools'],
            ['name' => 'VS Code', 'category' => 'Tools'],
            ['name' => 'Neovim', 'category' => 'Tools'],
        ];

        foreach ($skills as $index => $skillData) {
            Skill::create([
                'name' => $skillData['name'],
                'skill_category_id' => $categories[$skillData['category']],
                'proficiency' => rand(60, 99),
                'icon' => null,
                'order' => $index,
            ]);
        }
    }
}
