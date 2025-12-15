<?php

namespace Database\Seeders;

use App\Models\InfoPpdb;
use App\Models\User;
use Illuminate\Database\Seeder;

class InfoPpdbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first(); 
        
        // Ensure at least one user exists; if valid UserSeeder runs first, this should be fine.
        // Fallback or just skip if no user.
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Admin PPDB',
                'email' => 'ppdb@example.com', 
            ]);
        }

        InfoPpdb::create([
            'judul' => 'Panduan Pendaftaran Tahun 2025/2026',
            'deskripsi' => 'Berikut adalah panduan lengkap cara mendaftar di PKBM Harapan Bangsa untuk tahun ajaran baru. Pastikan Anda menyiapkan dokumen-dokumen yang diperlukan seperti KK, Akta Kelahiran, dan Ijazah Terakhir.',
            'penulis_id' => $user->id,
        ]);

        InfoPpdb::create([
            'judul' => 'Jadwal Gelombang 1',
            'deskripsi' => 'Pendaftaran Gelombang 1 dibuka mulai tanggal 1 Januari 2025 sampai dengan 31 Maret 2025. Dapatkan potongan biaya pendaftaran bagi 50 pendaftar pertama.',
            'penulis_id' => $user->id,
        ]);

        InfoPpdb::create([
            'judul' => 'Syarat dan Ketentuan',
            'deskripsi' => 'Calon siswa harus berusia minimal 7 tahun untuk Paket A, 13 tahun untuk Paket B, dan 16 tahun untuk Paket C. Tidak ada batasan usia maksimal.',
            'penulis_id' => $user->id,
        ]);
    }
}
