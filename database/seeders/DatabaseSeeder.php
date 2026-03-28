<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Titan',
            'email' => 'titanaprilian73@gmail.com',
            'password' => bcrypt('password123'),
        ]);

        $this->call([
            ProjectCategorySeeder::class,
            ProjectTagSeeder::class,
            ProjectSeeder::class,
            PostCategorySeeder::class,
            PostTagSeeder::class,
            PostSeeder::class,
            SkillCategorySeeder::class,
            SkillSeeder::class,
            ExperienceSeeder::class,
            ContactSeeder::class,
            ResumeSeeder::class,
        ]);
    }
}
