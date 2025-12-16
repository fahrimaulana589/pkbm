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
        $user = User::first() ?? User::factory()->create();

        $infos = [
            [
                'judul' => 'Alur Pendaftaran Peserta Didik Baru',
                'deskripsi' => '<p>1. Calon peserta didik mengisi formulir pendaftaran online.<br>2. Melakukan pembayaran biaya pendaftaran.<br>3. Menyerahkan berkas fisik ke sekretariat.<br>4. Mengikuti wawancara dan tes penempatan.</p>',
            ],
            [
                'judul' => 'Persyaratan Berkas Paket C (Setara SMA)',
                'deskripsi' => '<ul><li>Fotokopi Ijazah SMP/MTs (Legalisir) - 3 Lembar</li><li>Fotokopi SKHUN SMP/MTs - 3 Lembar</li><li>Fotokopi KK dan KTP Orang Tua</li><li>Pas Foto 3x4 (Warna Merah) - 5 Lembar</li></ul>',
            ],
            [
                'judul' => 'Beasiswa Pendidikan',
                'deskripsi' => '<p>PKBM Harapan Bangsa menyediakan beasiswa <strong>"Indonesia Pintar"</strong> bagi siswa berprestasi dan kurang mampu. Hubungi panitia untuk persyaratan lebih lanjut.</p>',
            ],
            [
                'judul' => 'Biaya Pendidikan',
                'deskripsi' => '<p>Biaya pendaftaran: Rp 150.000<br>SPP Bulanan: Rp 100.000 (Paket B), Rp 150.000 (Paket C)<br><em>*Bebas biaya gedung untuk 50 pendaftar pertama.</em></p>',
            ],
        ];

        foreach ($infos as $info) {
            InfoPpdb::create([
                'judul' => $info['judul'],
                'deskripsi' => $info['deskripsi'],
                'penulis_id' => $user->id,
            ]);
        }
    }
}
