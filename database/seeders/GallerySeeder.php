<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\GalleryPhoto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Storage::disk('public')->makeDirectory('gallery');

        // Data Album Real
        $albums = [
            [
                'judul' => 'Kegiatan Belajar Mengajar',
                'deskripsi' => 'Dokumentasi aktivitas pembelajaran di dalam kelas Paket A, B, dan C.',
                'kategori' => 'kegiatan',
                'fotos' => [
                    'Suasana Kelas Paket C',
                    'Praktik Komputer',
                    'Diskusi Kelompok'
                ]
            ],
            [
                'judul' => 'Perayaan Hari Besar Nasional',
                'deskripsi' => 'Kegiatan peringatan hari-hari besar seperti 17 Agustus, Hari Pendidikan, dll.',
                'kategori' => 'event',
                'fotos' => [
                    'Upacara Bendera',
                    'Lomba Balap Karung',
                    'Pentasa Seni Siswa'
                ]
            ],
            [
                'judul' => 'Fasilitas PKBM',
                'deskripsi' => 'Foto-foto fasilitas sarana dan prasarana penunjang pembelajaran.',
                'kategori' => 'fasilitas',
                'fotos' => [
                    'Ruang Lab Komputer',
                    'Perpustakaan',
                    'Aula Serbaguna',
                    'Musholla'
                ]
            ],
            [
                'judul' => 'Outing Class',
                'deskripsi' => 'Kegiatan belajar di luar kelas dan kunjungan edukatif.',
                'kategori' => 'kegiatan',
                'fotos' => [
                    'Kunjungan Museum',
                    'Wisata Alam',
                    'Studi Banding'
                ]
            ]
        ];

        foreach ($albums as $albumData) {
            // Create Album
            $gallery = Gallery::create([
                'judul' => $albumData['judul'],
                'deskripsi' => $albumData['deskripsi'],
                'kategori' => $albumData['kategori'],
                'tanggal' => now()->subDays(rand(1, 100)),
                'status' => 'aktif',
            ]);

            // Create Photos
            foreach ($albumData['fotos'] as $fotoJudul) {
                // Generate Files
                $fileName = 'gallery/' . Str::slug($fotoJudul) . '-' . uniqid() . '.jpg';
                $this->createDummyImage($fileName, $fotoJudul);

                GalleryPhoto::create([
                    'gallery_id' => $gallery->id,
                    'file_path' => $fileName,
                    'caption' => $fotoJudul,
                ]);
            }
        }
    }

    private function createDummyImage($path, $text)
    {
        if (!extension_loaded('gd')) {
            Storage::disk('public')->put($path, '');
            return;
        }

        $width = 800;
        $height = 600;
        $image = imagecreatetruecolor($width, $height);
        $bg = imagecolorallocate($image, rand(200, 240), rand(200, 240), rand(200, 240));
        imagefilledrectangle($image, 0, 0, $width, $height, $bg);
        $textColor = imagecolorallocate($image, 50, 50, 50);
        $font = 5;
        $textWidth = imagefontwidth($font) * strlen($text);
        $textHeight = imagefontheight($font);
        imagestring($image, $font, ($width - $textWidth) / 2, ($height - $textHeight) / 2, $text, $textColor);

        ob_start();
        imagejpeg($image);
        $contents = ob_get_clean();
        imagedestroy($image);

        Storage::disk('public')->put($path, $contents);
    }
}
