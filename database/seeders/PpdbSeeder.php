<?php

namespace Database\Seeders;

use App\Models\Ppdb;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PpdbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ppdb::factory()->count(1)->create([
            'name' => 'PPDB',
            'tahun' => 2025,
            'status' => 'open',
            'start_date' => now(),
            'end_date' => now()->addMonths(1),
        ]);
    }
}
