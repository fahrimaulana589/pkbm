<?php

namespace Database\Seeders;

use App\Models\ClassGroup;
use App\Models\Program;
use App\Models\Tutor;
use Illuminate\Database\Seeder;

class ClassGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil program Utama (Paket A, B, C)
        $programs = Program::whereIn('kategori', ['Paket A', 'Paket B', 'Paket C'])->get();
        $tutors = Tutor::all();

        if ($programs->isEmpty() || $tutors->isEmpty()) {
            return;
        }

        // Mapping Program ke Nama Rombel yang Logis
        foreach ($programs as $program) {
            $levels = [];
            if ($program->kategori === 'Paket A') {
                $levels = ['Kelas 4', 'Kelas 5', 'Kelas 6'];
            } elseif ($program->kategori === 'Paket B') {
                $levels = ['Kelas 7', 'Kelas 8', 'Kelas 9'];
            } elseif ($program->kategori === 'Paket C') {
                $levels = ['Kelas 10', 'Kelas 11', 'Kelas 12'];
            }

            foreach ($levels as $level) {
                // Pilih Tutor Acak sebagai Wali Kelas
                $waliKelas = $tutors->random();
                
                ClassGroup::create([
                    'program_id' => $program->id,
                    'tutor_id' => $waliKelas->id,
                    'nama_rombel' => $level . ' - ' . date('Y'),
                    'periode' => date('Y') . '/' . (date('Y') + 1),
                ]);
            }
        }

        // Tambahan Rombel Kursus jika ada
        $kursus = Program::where('kategori', 'Kursus')->get();
        foreach ($kursus as $program) {
            $tutor = $tutors->random();
            ClassGroup::create([
                'program_id' => $program->id,
                'tutor_id' => $tutor->id,
                'nama_rombel' => 'Angkatan ' . rand(1, 5),
                'periode' => date('Y'),
            ]);
        }
    }
}
