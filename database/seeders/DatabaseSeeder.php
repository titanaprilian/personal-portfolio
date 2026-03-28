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
            PostCategorySeeder::class,
            PostTagSeeder::class,
            SkillCategorySeeder::class,
            SkillSeeder::class,
        ]);
    }
}
