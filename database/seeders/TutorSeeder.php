<?php

namespace Database\Seeders;

use App\Models\Tutor;
use Illuminate\Database\Seeder;

class TutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tutors = [
            [
                'nama' => 'Drs. Supriyadi, M.Pd.',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Melati No. 10, Cimahi',
                'pendidikan_terakhir' => 'S2 Pendidikan Matematika',
                'keahlian' => 'Matematika, Fisika',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Siti Aminah, S.Pd.',
                'no_hp' => '081345678901',
                'alamat' => 'Jl. Mawar No. 5, Bandung',
                'pendidikan_terakhir' => 'S1 Pendidikan Bahasa Indonesia',
                'keahlian' => 'Bahasa Indonesia, Sastra',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Rudi Hartono, S.Kom.',
                'no_hp' => '081456789012',
                'alamat' => 'Komp. Permata Indah Blok C',
                'pendidikan_terakhir' => 'S1 Teknik Informatika',
                'keahlian' => 'Komputer, Desain Grafis',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Dewi Sartika, S.Pd.',
                'no_hp' => '081567890123',
                'alamat' => 'Jl. Pahlawan No. 100',
                'pendidikan_terakhir' => 'S1 Pendidikan Bahasa Inggris',
                'keahlian' => 'Bahasa Inggris',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Ahmad Fauzi, S.E.',
                'no_hp' => '081678901234',
                'alamat' => 'Gg. H. Nawi, Jakarta',
                'pendidikan_terakhir' => 'S1 Akuntansi',
                'keahlian' => 'Ekonomi, Kewirausahaan',
                'status' => 'aktif',
            ],
        ];

        foreach ($tutors as $tutor) {
            Tutor::create($tutor);
        }
    }
}
