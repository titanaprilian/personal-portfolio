<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $categories = PostCategory::all();
        $tags = PostTag::all();

        Post::factory()->published()->count(10)->create()->each(function (Post $post) use ($categories, $tags) {
            $post->update(['category_id' => $categories->random()->id]);
            $post->tags()->attach($tags->random(fake()->numberBetween(2, 4))->pluck('id'));
        });

        Post::factory()->draft()->count(2)->create()->each(function (Post $post) use ($categories, $tags) {
            $post->update(['category_id' => $categories->random()->id]);
            $post->tags()->attach($tags->random(fake()->numberBetween(1, 3))->pluck('id'));
        });
    }
}
