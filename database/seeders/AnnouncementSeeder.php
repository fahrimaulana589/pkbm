<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 active announcement records
        Announcement::factory(20)->create([
            'status' => 'dipublikasikan',
            'published_at' => now(),
        ]);
    }
}