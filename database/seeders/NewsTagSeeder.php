<?php

namespace Database\Seeders;

use App\Models\NewsTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Pendidikan',
            'Kurikulum Merdeka',
            'Beasiswa',
            'Prestasi Siswa',
            'Ekstrakurikuler',
            'Ujian Nasional',
            'PPDB',
            'Alumni',
            'Literasi',
            'Teknologi',
            'Kewirausahaan'
        ];

        foreach ($tags as $tagName) {
            NewsTag::firstOrCreate(
                ['slug' => Str::slug($tagName)],
                ['nama_tag' => $tagName]
            );
        }
    }
}
