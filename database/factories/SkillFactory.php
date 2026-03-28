<?php

namespace Database\Factories;

use App\Models\SkillCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    public function definition(): array
    {
        $categories = SkillCategory::all();
        $category = $categories->random();

        return [
            'name' => fake()->unique()->word(),
            'skill_category_id' => $category->id,
            'proficiency' => fake()->numberBetween(60, 99),
            'icon' => null,
            'order' => fake()->numberBetween(0, 20),
        ];
    }
}
