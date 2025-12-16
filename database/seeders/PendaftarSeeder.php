<?php

namespace Database\Seeders;

use App\Models\Pendaftar;
use App\Models\Program;
use App\Models\Ppdb;
use App\Enums\PendaftarStatus;
use Illuminate\Database\Seeder;

class PendaftarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = Program::all();
        // Ambil PPDB yang Open, fallback ke first
        $ppdb = Ppdb::where('status', 'open')->first() ?? Ppdb::first();

        if ($programs->isEmpty()) {
            return;
        }

        $applicants = [
            ['Rina Marlina', 'Bandung', '2005-05-12', 'Jl. Merdeka No. 1', 'rina@example.com', '081234567800', PendaftarStatus::DITERIMA],
            ['Budi Santoso', 'Cimahi', '2006-08-20', 'Jl. Jendral Sudirman No. 45', 'budi@example.com', '081234567801', PendaftarStatus::DIPROSES],
            ['Siti Aisyah', 'Garut', '2007-01-15', 'Kp. Suka Maju RT 01/02', 'siti@example.com', '081234567802', PendaftarStatus::TERDAFTAR],
            ['Doni Kurniawan', 'Tasikmalaya', '2004-12-05', 'Jl. Tentara Pelajar', 'doni@example.com', '081234567803', PendaftarStatus::DITERIMA],
            ['Euis Komala', 'Sumedang', '2005-03-30', 'Dusun Cileunyi', 'euis@example.com', '081234567804', PendaftarStatus::DITOLAK],
            ['Fajar Sodiq', 'Subang', '2006-07-22', 'Perum Subang Asri', 'fajar@example.com', '081234567805', PendaftarStatus::DIPROSES],
            ['Gita Gutawa', 'Jakarta', '2005-09-09', 'Jl. Thamrin Jakarta', 'gita@example.com', '081234567806', PendaftarStatus::TERDAFTAR],
            ['Hasan Basri', 'Bekasi', '2003-11-18', 'Jl. Raya Bekasi km 7', 'hasan@example.com', '081234567807', PendaftarStatus::DITERIMA],
            ['Indra Lesmana', 'Bogor', '2004-02-28', 'Jl. Pajajaran Bogor', 'indra@example.com', '081234567808', PendaftarStatus::DITERIMA],
            ['Joko Anwar', 'Depok', '2006-04-14', 'Jl. Margonda Raya', 'joko@example.com', '081234567809', PendaftarStatus::DIPROSES],
        ];

        foreach ($applicants as $data) {
            $program = $programs->random();
            
            Pendaftar::create([
                'program_id' => $program->id,
                // 'ppdb_id' => $ppdb?->id, // Jika ada relasi ke PPDB di table pendaftars, tapi di migration Step 456 tidak ada kolom ppdb_id. Skip.
                'name' => $data[0],
                'birth_place' => $data[1],
                'birth_date' => $data[2],
                'address' => $data[3],
                'email' => $data[4],
                'phone' => $data[5],
                'status' => $data[6],
                'code' => Pendaftar::generateUniqueCode(),
                'extra_attributes' => [
                    'nama_ayah' => 'Bapak ' . $data[0],
                    'nama_ibu' => 'Ibu ' . $data[0],
                    'pekerjaan_ayah' => 'Wiraswasta',
                    'ukuran_baju' => ['M', 'L', 'XL'][rand(0, 2)],
                ]
            ]);
        }
    }
}
