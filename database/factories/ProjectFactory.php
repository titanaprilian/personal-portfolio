<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        static $titles = null;
        static $counter = 1;

        if ($titles === null) {
            $titles = [
                'Portfolio OS',
                'DevTrack',
                'CodeVault',
                'Launchpad',
                'NightOwl API',
                'Stackr',
                'PulseBoard',
                'Monorepo CLI',
                'GitLens Pro',
                'SnapDeploy',
                'TaskFlow',
                'DataForge',
            ];
            shuffle($titles);
        }

        $title = array_shift($titles).' v'.$counter++.'.0';

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraph(2),
            'body' => fake()->paragraphs(4, true),
            'thumbnail' => null,
            'demo_url' => fake()->boolean(70) ? fake()->url() : null,
            'github_url' => 'https://github.com/username/'.Str::slug($title),
            'featured' => fake()->boolean(30),
            'order' => fake()->numberBetween(0, 20),
        ];
    }
}
