<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectTagFactory extends Factory
{
    public function definition(): array
    {
        static $pool = null;
        if ($pool === null) {
            $pool = [
                'Laravel',
                'Vue.js',
                'React',
                'Alpine.js',
                'Tailwind CSS',
                'Node.js',
                'TypeScript',
                'PostgreSQL',
                'MySQL',
                'Redis',
                'Docker',
                'AWS',
                'Livewire',
                'Inertia.js',
                'Next.js',
                'Python',
                'FastAPI',
                'GraphQL',
                'REST API',
                'Three.js',
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
