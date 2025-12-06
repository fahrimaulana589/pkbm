<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\GalleryPhoto;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gallery::factory()->count(5)->create()->each(function ($gallery) {
            GalleryPhoto::factory()->count(rand(3, 8))->create([
                'gallery_id' => $gallery->id,
            ]);
        });
    }
}
