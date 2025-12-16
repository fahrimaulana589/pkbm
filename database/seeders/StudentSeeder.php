<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str; // Import Str

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil Program yang sudah dibuat
        $programs = Program::all();

        if ($programs->isEmpty()) {
            return;
        }

        $names = [
            'Aditya Pratama', 'Bayu Saputra', 'Citra Lestari', 'Dimas Anggara', 'Eka Putri',
            'Fajar Nugraha', 'Gita Pertiwi', 'Hendra Wijaya', 'Indah Sari', 'Joko Susilo',
            'Kartika Dewi', 'Lukman Hakim', 'Maya Safitri', 'Nanda Rizky', 'Oki Setiawan',
            'Putri Ayu', 'Rizky Ramadhan', 'Sari Handayani', 'Tono Sudiro', 'Vina Amalia'
        ];

        foreach ($names as $index => $name) {
            // Assign random program
            $program = $programs->random();
            
            Student::create([
                'program_id' => $program->id,
                'nik' => '32770' . rand(1000000000, 9999999999), // Dummy NIK valid length
                'nisn' => '00' . rand(10000000, 99999999),
                'nama_lengkap' => $name,
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => now()->subYears(rand(15, 25))->format('Y-m-d'),
                'jenis_kelamin' => $index % 2 == 0 ? 'L' : 'P',
                'alamat' => 'Jl. Kebon Jeruk No. ' . rand(1, 100),
                'no_hp' => '08' . rand(1000000000, 9999999999),
                'status' => 'aktif',
            ]);
        }
    }
}
