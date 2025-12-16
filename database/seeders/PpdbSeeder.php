<?php

namespace Database\Seeders;

use App\Models\Ppdb;
use Illuminate\Database\Seeder;

class PpdbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Batch Tahun Lalu (Closed)
        Ppdb::create([
            'name' => 'PPDB Gelombang 1',
            'tahun' => 2024,
            'status' => 'closed',
            'start_date' => now()->subYear()->startOfYear(),
            'end_date' => now()->subYear()->endOfYear(),
        ]);

        // Batch Tahun Ini (Open)
        Ppdb::create([
            'name' => 'PPDB Gelombang 2',
            'tahun' => 2025,
            'status' => 'open',
            'start_date' => now()->startOfMonth(),
            'end_date' => now()->addMonths(2)->endOfMonth(),
        ]);
    }
}
