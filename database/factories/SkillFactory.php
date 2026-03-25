<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    public function definition(): array
    {
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

        $skill = fake()->unique()->randomElement($skills);

        return [
            'name' => $skill['name'],
            'category' => $skill['category'],
            'proficiency' => fake()->numberBetween(60, 99),
            'icon' => null,
            'order' => fake()->numberBetween(0, 20),
        ];
    }
}
