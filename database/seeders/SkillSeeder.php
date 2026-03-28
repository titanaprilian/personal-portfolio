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
            ['name' => 'Laravel', 'category' => 'Backend'],
            ['name' => 'PHP', 'category' => 'Backend'],
            ['name' => 'Node.js', 'category' => 'Backend'],
            ['name' => 'MySQL', 'category' => 'Backend'],
            ['name' => 'PostgreSQL', 'category' => 'Backend'],
            ['name' => 'Redis', 'category' => 'Backend'],
            ['name' => 'Vue.js', 'category' => 'Frontend'],
            ['name' => 'React', 'category' => 'Frontend'],
            ['name' => 'Alpine.js', 'category' => 'Frontend'],
            ['name' => 'Tailwind CSS', 'category' => 'Frontend'],
            ['name' => 'TypeScript', 'category' => 'Frontend'],
            ['name' => 'Three.js', 'category' => 'Frontend'],
            ['name' => 'Docker', 'category' => 'DevOps'],
            ['name' => 'AWS', 'category' => 'DevOps'],
            ['name' => 'GitHub Actions', 'category' => 'DevOps'],
            ['name' => 'Linux', 'category' => 'DevOps'],
            ['name' => 'Git', 'category' => 'Tools'],
            ['name' => 'Figma', 'category' => 'Tools'],
            ['name' => 'VS Code', 'category' => 'Tools'],
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
