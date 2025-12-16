<?php

namespace Database\Seeders;

use App\Models\DataPpdb;
use App\Models\Ppdb;
use App\Enums\DataPpdbType;
use Illuminate\Database\Seeder;

class DataPpdbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil PPDB Aktif
        $ppdb = Ppdb::where('status', 'open')->first();

        if (!$ppdb) {
            $ppdb = Ppdb::create([
                'name' => 'PPDB Tahun Ini',
                'tahun' => date('Y'),
                'status' => 'open',
                'start_date' => now(),
                'end_date' => now()->addMonths(2),
            ]);
        }

        $requirements = [
            [
                'nama' => 'Pas Foto 3x4',
                'jenis' => DataPpdbType::FILE,
                'status' => 'aktif',
                'default' => true,
            ],
            [
                'nama' => 'Kartu Keluarga (KK)',
                'jenis' => DataPpdbType::FILE,
                'status' => 'aktif',
                'default' => true,
            ],
            [
                'nama' => 'Akte Kelahiran',
                'jenis' => DataPpdbType::FILE,
                'status' => 'aktif',
                'default' => true,
            ],
            [
                'nama' => 'Ijazah Terakhir',
                'jenis' => DataPpdbType::FILE,
                'status' => 'aktif',
                'default' => true,
            ],
            [
                'nama' => 'NISN',
                'jenis' => DataPpdbType::TEXT,
                'status' => 'aktif',
                'default' => false, // Opsional
            ],
        ];

        foreach ($requirements as $req) {
            DataPpdb::firstOrCreate([
                'ppdb_id' => $ppdb->id,
                'nama' => $req['nama'],
            ], [
                'jenis' => $req['jenis'],
                'status' => $req['status'],
                'default' => $req['default'],
            ]);
        }
    }
}
