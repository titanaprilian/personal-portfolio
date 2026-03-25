<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExperienceFactory extends Factory
{
    public function definition(): array
    {
        $isCurrent = fake()->boolean(25);

        return [
            'company' => fake()->company(),
            'role' => fake()->randomElement([
                'Software Engineer',
                'Backend Developer',
                'Full Stack Developer',
                'Frontend Engineer',
                'Lead Developer',
                'Junior Developer',
            ]),
            'description' => fake()->paragraph(3),
            'start_date' => fake()->dateTimeBetween('-6 years', '-1 year'),
            'end_date' => $isCurrent ? null : fake()->dateTimeBetween('-1 year', 'now'),
            'is_current' => $isCurrent,
            'order' => fake()->numberBetween(0, 10),
        ];
    }

    public function current(): static
    {
        return $this->state(fn () => [
            'is_current' => true,
            'end_date' => null,
        ]);
    }
}
