<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostCategoryFactory extends Factory
{
    public function definition(): array
    {
        static $pool = null;
        if ($pool === null) {
            $pool = [
                'Laravel',
                'JavaScript',
                'DevOps',
                'Career',
                'Open Source',
                'Tutorials',
                'Tools & Workflow',
                'System Design',
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
