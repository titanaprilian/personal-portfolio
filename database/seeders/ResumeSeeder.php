<?php

namespace Database\Seeders;

use App\Models\Resume;
use Illuminate\Database\Seeder;

class ResumeSeeder extends Seeder
{
    public function run(): void
    {
        Resume::factory()->count(2)->create();
        Resume::latest()->first()->update(['is_active' => true]);
    }
}
