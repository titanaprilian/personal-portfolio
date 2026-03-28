<?php

namespace Database\Seeders;

use App\Models\PostTag;
use Illuminate\Database\Seeder;

class PostTagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'php',
            'laravel',
            'bun',
            'docker',
            'nodejs',
            'elysia',
        ];

        foreach ($tags as $tag) {
            PostTag::create(['name' => $tag]);
        }
    }
}
