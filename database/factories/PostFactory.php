<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        static $titles = null;
        static $counter = 1;

        if ($titles === null) {
            $titles = [
                'Getting Started with Laravel 12',
                'Building a REST API with Sanctum',
                'Deploying Laravel with Docker',
                'Mastering Eloquent Relationships',
                'Tailwind CSS Tips & Tricks',
                'Writing Clean PHP in 2025',
                'A Deep Dive into Queue Workers',
                'Using Alpine.js with Blade',
                'My Journey Into Open Source',
                'How I Structure Laravel Projects',
            ];
            shuffle($titles);
        }

        $title = array_shift($titles).' ('.$counter++.')';

        static $order = null;
        if ($order === null) {
            $order = Post::max('order') ?? -1;
        }

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => fake()->paragraphs(6, true),
            'thumbnail' => null,
            'reading_time' => fake()->numberBetween(3, 15),
            'published_at' => fake()->boolean(80) ? fake()->dateTimeBetween('-1 year', 'now') : null,
            'category_id' => null,
            'order' => ++$order,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'published_at' => null,
        ]);
    }
}
