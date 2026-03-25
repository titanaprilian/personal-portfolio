<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        Contact::factory()->count(5)->create();

        Contact::factory()->count(3)->create()->each(
            fn (Contact $contact) => $contact->update([
                'read_at' => now()->subDays(fake()->numberBetween(1, 10)),
            ])
        );
    }
}
