<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectCategoryFactory extends Factory
{
    public function definition(): array
    {
        static $pool = null;
        if ($pool === null) {
            $pool = [
                'Web App',
                'Mobile App',
                'API',
                'CLI Tool',
                'Open Source',
                'UI/UX',
                'DevOps',
                'Machine Learning',
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
