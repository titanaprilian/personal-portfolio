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

        $orders = range(0, 9);
        shuffle($orders);

        Project::factory()->count(10)->create()->each(function (Project $project) use ($categories, $tags, &$orders) {
            $project->categories()->attach(
                $categories->random(fake()->numberBetween(1, 3))->pluck('id')
            );
            $project->tags()->attach(
                $tags->random(fake()->numberBetween(2, 5))->pluck('id')
            );
            $project->update(['order' => array_shift($orders)]);
        });

        $featuredProjects = Project::inRandomOrder()->limit(3)->get();
        foreach ($featuredProjects as $index => $project) {
            $project->update(['featured_order' => $index + 1]);
        }
    }
}
