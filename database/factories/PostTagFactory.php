<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostTagFactory extends Factory
{
    public function definition(): array
    {
        static $pool = null;
        if ($pool === null) {
            $pool = [
                'php',
                'laravel',
                'javascript',
                'vue',
                'react',
                'css',
                'tailwind',
                'docker',
                'git',
                'api',
                'testing',
                'performance',
                'security',
                'deployment',
                'architecture',
                'beginners',
            ];
            shuffle($pool);
        }
        $name = array_pop($pool);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
