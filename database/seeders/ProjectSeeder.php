<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectTag;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ProjectCategory::all();
        $tags = ProjectTag::all();

        Project::factory()->count(10)->create()->each(function (Project $project) use ($categories, $tags) {
            $project->categories()->attach(
                $categories->random(fake()->numberBetween(1, 3))->pluck('id')
            );
            $project->tags()->attach(
                $tags->random(fake()->numberBetween(2, 5))->pluck('id')
            );
        });

        Project::inRandomOrder()->limit(3)->get()->each(
            fn (Project $project) => $project->update(['featured' => true])
        );
    }
}
