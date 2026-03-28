<?php

namespace Database\Seeders;

use App\Models\ProjectTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectTagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Laravel',
            'React',
            'Tailwind',
            'Node.js',
            'Typescript',
            'Postgres',
            'Mysql',
            'docker',
            'nextjs',
        ];

        foreach ($tags as $tag) {
            ProjectTag::create([
                'name' => $tag,
                'slug' => Str::slug($tag),
            ]);
        }
    }
}
