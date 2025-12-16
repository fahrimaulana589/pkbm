<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Valid Kategori: ['Paket A', 'Paket B', 'Paket C', 'Keaksaraan', 'Kursus', 'Pelatihan', 'Life Skill']
        // Valid Status: ['aktif', 'nonaktif']
        $programs = [
            [
                'kategori' => 'Paket A',
                'nama_program' => 'Paket A (Setara SD) Kelas 4, 5, 6',
                'deskripsi' => 'Program pendidikan kesetaraan tingkat dasar yang setara dengan Sekolah Dasar (SD). Kurikulum dirancang untuk memberikan kompetensi dasar membaca, menulis, berhitung, dan pembentukan karakter.',
                'durasi' => '3 Tahun (Sesuai Konversi)',
                'status' => 'aktif',
            ],
            [
                'kategori' => 'Paket B',
                'nama_program' => 'Paket B (Setara SMP) Kelas 7, 8, 9',
                'deskripsi' => 'Program pendidikan kesetaraan tingkat menengah pertama yang setara dengan Sekolah Menengah Pertama (SMP). Fokus pada pengembangan wawasan ilmu pengetahuan, teknologi, seni, dan budaya.',
                'durasi' => '3 Tahun',
                'status' => 'aktif',
            ],
            [
                'kategori' => 'Paket C',
                'nama_program' => 'Paket C (Setara SMA) IPS',
                'deskripsi' => 'Program pendidikan kesetaraan tingkat menengah atas yang setara dengan Sekolah Menengah Atas (SMA) Jurusan IPS.',
                'durasi' => '3 Tahun',
                'status' => 'aktif',
            ],
            [
                'kategori' => 'Kursus',
                'nama_program' => 'Kursus Komputer Perkantoran',
                'deskripsi' => 'Pelatihan penguasaan Microsoft Office (Word, Excel, PowerPoint) untuk persiapan dunia kerja administrasi perkantoran. Bersertifikat kompetensi.',
                'durasi' => '3 Bulan',
                'status' => 'aktif',
            ],
            [
                'kategori' => 'Pelatihan',
                'nama_program' => 'Tata Boga & Pastry',
                'deskripsi' => 'Pelatihan keterampilan memasak dan membuat kue. Peserta diajarkan teknik dasar hingga "food plating" dan manajemen usaha kuliner rumahan.',
                'durasi' => '6 Bulan',
                'status' => 'aktif',
            ],
            [
                'kategori' => 'Life Skill',
                'nama_program' => 'Teknik Sepeda Motor',
                'deskripsi' => 'Program vokasi untuk mencetak mekanik sepeda motor yang handal. Bekerja sama dengan bengkel-bengkel resmi di daerah.',
                'durasi' => '1 Tahun',
                'status' => 'aktif',
            ],
            [
                'kategori' => 'Keaksaraan',
                'nama_program' => 'Taman Bacaan Masyarakat (TBM)',
                'deskripsi' => 'Layanan literasi gratis untuk masyarakat sekitar. Menyediakan buku bacaan anak, remaja, dan dewasa serta kegiatan mendongeng mingguan.',
                'durasi' => 'Permanen',
                'status' => 'aktif',
            ],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}
