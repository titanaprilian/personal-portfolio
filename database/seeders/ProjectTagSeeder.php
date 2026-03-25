<?php

namespace Database\Seeders;

use App\Models\ProjectTag;
use Illuminate\Database\Seeder;

class ProjectTagSeeder extends Seeder
{
    public function run(): void
    {
        ProjectTag::factory()->count(12)->create();
    }
}
