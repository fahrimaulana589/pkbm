<?php

namespace Database\Seeders;

use App\Models\NewsCategory;
use Illuminate\Database\Seeder;

class NewsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Kegiatan', 'Pengumuman', 'Prestasi', 'Artikel'];
        
        foreach ($categories as $category) {
            NewsCategory::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($category)],
                ['nama_kategori' => $category]
            );
        }
    }
}
