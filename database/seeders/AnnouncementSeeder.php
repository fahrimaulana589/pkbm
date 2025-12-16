<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan Direktori Ada
        Storage::disk('public')->makeDirectory('pengumuman/lampiran');
        Storage::disk('public')->makeDirectory('pengumuman/thumbnail');

        // Cari User ID (Admin/Penulis)
        $user = User::first() ?? User::factory()->create();

        // Data Pengumuman Real
        // Valid Kategori: ["Umum", "Akademik", "Kesiswaan", "Kepegawaian", "Kegiatan", "Darurat"]
        // Valid Prioritas: ["Normal", "Tinggi", "Penting"]
        $data = [
            [
                'judul' => 'Pengumuman Libur Hari Raya Idul Fitri 1446 H',
                'isi' => '<p>Sehubungan dengan Hari Raya Idul Fitri 1446 H, kegiatan belajar mengajar di PKBM Harapan Bangsa diliburkan mulai tanggal <strong>25 Maret hingga 5 April</strong>. KBM akan aktif kembali pada hari Senin, 7 April.</p><p>Segenap pengurus mengucapkan Minal Aidin Wal Faizin, Mohon Maaf Lahir dan Batin.</p>',
                'kategori' => 'Akademik',
                'prioritas' => 'Tinggi',
                'image_text' => 'Libur Lebaran',
                'has_file' => true,
            ],
            [
                'judul' => 'Jadwal Pengambilan Ijazah Paket C Tahap 1',
                'isi' => '<p>Bagi lulusan Paket C Tahun Ajaran 2024/2025 (Tahap 1), ijazah sudah dapat diambil di sekretariat mulai tanggal 1 Oktober pada jam kerja (08.00 - 15.00 WIB).</p><p>Syarat pengambilan: Membawa Kartu Identitas Asli dan Cap 3 Jari.</p>',
                'kategori' => 'Kesiswaan', // Mapped from Administrasi
                'prioritas' => 'Penting',
                'image_text' => 'Bagi Ijazah',
                'has_file' => false,
            ],
            [
                'judul' => 'Sosialisasi Bantuan Operasional Pendidikan (BOP)',
                'isi' => '<p>Mengundang seluruh orang tua wali murid untuk hadir dalam rapat sosialisasi penggunaan dana BOP tahun anggaran berjalan. Kegiatan akan dilaksanakan di Aula Utama.</p>',
                'kategori' => 'Umum', // Mapped from Keuangan
                'prioritas' => 'Normal',
                'image_text' => 'Rapat BOP',
                'has_file' => true,
            ],
            [
                'judul' => 'Pendaftaran Peserta Didik Baru (PPDB) Gelombang 2',
                'isi' => '<p>PPDB Gelombang 2 telah dibuka untuk Paket A, B, dan C. Segera daftarkan diri Anda sebelum kuota penuh. Potongan biaya pendaftaran 50% bagi pendaftar di bulan ini.</p>',
                'kategori' => 'Kesiswaan', // Mapped from Pendaftaran
                'prioritas' => 'Tinggi',
                'image_text' => 'PPDB Dibuka',
                'has_file' => true,
            ],
        ];

        foreach ($data as $item) {
            // Generate Thumbnail
            $thumbName = 'pengumuman/thumbnail/' . Str::slug($item['judul']) . '.jpg';
            $this->createDummyImage($thumbName, $item['image_text']);

            // Generate File (Fake PDF)
            $fileName = null;
            if ($item['has_file']) {
                $fileName = 'pengumuman/lampiran/' . Str::slug($item['judul']) . '.pdf';
                // Isi dummy content text
                Storage::disk('public')->put($fileName, "Ini adalah file dummy PDF untuk pengumuman: " . $item['judul']);
            }

            Announcement::create([
                'judul' => $item['judul'],
                'slug' => Str::slug($item['judul']),
                'isi' => $item['isi'],
                'kategori' => $item['kategori'],
                'prioritas' => $item['prioritas'],
                'status' => 'dipublikasikan',
                'lampiran_file' => $fileName,
                'thumbnail' => $thumbName,
                'published_at' => now(),
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'penulis_id' => $user->id,
            ]);
        }
    }

    private function createDummyImage($path, $text)
    {
        if (!extension_loaded('gd')) {
            Storage::disk('public')->put($path, '');
            return;
        }

        $width = 800;
        $height = 400; // Landscape banner style
        $image = imagecreatetruecolor($width, $height);
        $bg = imagecolorallocate($image, rand(100, 200), rand(100, 200), rand(150, 255)); // Blue-ish
        imagefilledrectangle($image, 0, 0, $width, $height, $bg);
        $textColor = imagecolorallocate($image, 255, 255, 255);
        $font = 5;
        $textWidth = imagefontwidth($font) * strlen($text);
        $textHeight = imagefontheight($font);
        
        // Centering logic
        $x = ($width - $textWidth) / 2;
        $y = ($height - $textHeight) / 2;

        imagestring($image, $font, $x, $y, $text, $textColor);

        ob_start();
        imagejpeg($image);
        $contents = ob_get_clean();
        imagedestroy($image);

        Storage::disk('public')->put($path, $contents);
    }
}