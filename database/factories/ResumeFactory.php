<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ResumeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'label' => fake()->randomElement([
                'Resume v1',
                'Resume v2 – Backend Focus',
                'Resume v3 – Full Stack',
                'CV – March 2026',
            ]),
            'file_path' => 'resumes/placeholder.pdf',
            'is_active' => false,
        ];
    }
}
