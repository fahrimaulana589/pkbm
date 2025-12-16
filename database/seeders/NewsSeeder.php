<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan dependency dijalankan
        if (NewsCategory::count() === 0) {
            $this->call(NewsCategorySeeder::class);
        }
        if (NewsTag::count() === 0) {
            $this->call(NewsTagSeeder::class);
        }

        // Siapkan Folder Gambar
        Storage::disk('public')->makeDirectory('berita');

        // Data Berita Real
        $newsData = [
            [
                'kategori' => 'Kegiatan',
                'judul' => 'Peringatan Hari Kemerdekaan RI ke-79 di PKBM Harapan Bangsa',
                'konten' => '<p>Perayaan Hari Kemerdekaan Republik Indonesia tahun ini berlangsung meriah di PKBM Harapan Bangsa. Seluruh warga belajar dari Paket A, B, dan C turut serta dalam berbagai perlombaan tradisional seperti balap karung, makan kerupuk, dan tarik tambang.</p><p>Kepala PKBM menyampaikan bahwa kegiatan ini bertujuan untuk mempererat tali silaturahmi dan menanamkan semangat nasionalisme.</p>',
                'tags' => ['Pendidikan', 'Ekstrakurikuler'],
                'image_text' => 'HUT RI 79',
            ],
            [
                'kategori' => 'Pengumuman',
                'judul' => 'Jadwal Ujian Modul Pendidikan Kesetaraan Paket C',
                'konten' => '<p>Diberitahukan kepada seluruh warga belajar Paket C Kelas 12 bahwa Ujian Modul Akhir Semester akan dilaksanakan pada tanggal 10-15 Desember. Mohon persiapkan diri dengan baik dan melunasi administrasi sebelum tanggal 5 Desember.</p><p>Jadwal mata pelajaran dapat dilihat di papan pengumuman sekretariat.</p>',
                'tags' => ['Ujian Nasional', 'Kurikulum Merdeka'],
                'image_text' => 'Jadwal Ujian',
            ],
            [
                'kategori' => 'Prestasi',
                'judul' => 'Alumni Paket C Lolos Seleksi Masuk PTN Jalur SNBP',
                'konten' => '<p>Kabar membanggakan datang dari alumni PKBM Harapan Bangsa. Tiga lulusan tahun lalu berhasil diterima di Universitas Pendidikan Indonesia (UPI) dan Universitas Padjadjaran (UNPAD) melalui jalur prestasi.</p><p>Hal ini membuktikan bahwa lulusan pendidikan kesetaraan memiliki kualitas yang setara dan mampu bersaing di jenjang pendidikan tinggi.</p>',
                'tags' => ['Prestasi Siswa', 'Alumni', 'Beasiswa'],
                'image_text' => 'Prestasi Alumni',
            ],
            [
                'kategori' => 'Artikel',
                'judul' => 'Pentingnya Literasi Digital di Era Modern',
                'konten' => '<p>Di era serba digital ini, kemampuan memahami dan menggunakan teknologi informasi sangatlah krusial. PKBM Harapan Bangsa berkomitmen mengintegrasikan literasi digital dalam setiap pembelajaran.</p><p>Warga belajar tidak hanya diajarkan mengoperasikan komputer, tetapi juga etika berinternet dan cara memfilter informasi hoax.</p>',
                'tags' => ['Teknologi', 'Literasi'],
                'image_text' => 'Literasi Digital',
            ],
             [
                'kategori' => 'Kegiatan',
                'judul' => 'Kunjungan Edukatif ke Museum Geologi Bandung',
                'konten' => '<p>Warga belajar Paket A dan Paket B melaksanakan kegiatan pembelajaran luar kelas (Outing Class) ke Museum Geologi Bandung. Kegiatan ini bertujuan mengenalkan sejarah bumi dan kekayaan sumber daya alam Indonesia secara langsung.</p>',
                'tags' => ['Pendidikan', 'Kegiatan'],
                'image_text' => 'Kunjungan Museum',
            ],
        ];

        foreach ($newsData as $data) {
            // Cari Kategori ID
            $category = NewsCategory::where('nama_kategori', $data['kategori'])->first();
            if (!$category) continue;

            // Generate Image
            $imageName = 'berita/' . Str::slug($data['judul']) . '.jpg';
            $this->createDummyImage($imageName, $data['image_text']);

            // Create News
            $news = News::create([
                'kategori_id' => $category->id,
                'judul' => $data['judul'],
                'slug' => Str::slug($data['judul']),
                'konten' => $data['konten'],
                'gambar' => $imageName, // Path disimpan relatif terhadap disk public
                'status' => 'published',
            ]);

            // Attach Tags
            $tagIds = NewsTag::whereIn('nama_tag', $data['tags'])->pluck('id');
            $news->tags()->attach($tagIds);
        }
    }

    /**
     * Create a dummy image using PHP GD.
     */
    private function createDummyImage($path, $text)
    {
        $width = 800;
        $height = 600;
        
        // Cek apakah GD extension tersedia
        if (!extension_loaded('gd')) {
            // Jika tidak ada GD, buat file kosong saja agar tidak error, meski gambar rusak
            Storage::disk('public')->put($path, '');
            return;
        }

        $image = imagecreatetruecolor($width, $height);
        
        // Warna Background Random (Pastel)
        $bg = imagecolorallocate($image, rand(200, 255), rand(200, 255), rand(200, 255));
        imagefilledrectangle($image, 0, 0, $width, $height, $bg);
        
        // Warna Teks (Gelap)
        $textColor = imagecolorallocate($image, 50, 50, 50);
        
        // Tambahkan Teks Sederhana (Menggunakan Font Bawaan GD 1-5)
        // Font 5 adalah yang terbesar bawaan
        // Centering Text
        $fontSize = 5;
        $textWidth = imagefontwidth($fontSize) * strlen($text);
        $textHeight = imagefontheight($fontSize);
        $x = ($width - $textWidth) / 2;
        $y = ($height - $textHeight) / 2;
        
        imagestring($image, $fontSize, $x, $y, $text, $textColor);
        imagestring($image, 5, $x, $y + 30, 'PKBM Harapan Bangsa', $textColor);

        // Render ke Stream
        ob_start();
        imagejpeg($image);
        $contents = ob_get_clean();
        imagedestroy($image);

        // Simpan ke Storage
        Storage::disk('public')->put($path, $contents);
    }
}
