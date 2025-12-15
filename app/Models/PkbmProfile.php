<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PkbmProfile extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nama_pkbm',
        'npsn',
        'alamat',
        'provinsi',
        'kota',
        'kecamatan',
        'desa',
        'telepon',
        'email',
        'kepala_pkbm',
        'visi',
        'misi',
        'logo',
        'foto_sambutan',
        'kata_sambutan',
        // Identitas
        'jenjang_pendidikan',
        'status_sekolah',
        'rt_rw',
        'kode_pos',
        'negara',
        'lintang',
        'bujur',
        // Data Pelengkap
        'sk_pendirian',
        'tanggal_sk_pendirian',
        'status_kepemilikan',
        'sk_izin_operasional',
        'tanggal_sk_izin_operasional',
        'kebutuhan_khusus_dilayani',
        'nomor_rekening',
        'nama_bank',
        'cabang_kcp_unit',
        'rekening_atas_nama',
        'mbs',
        'memungut_iuran',
        'nominal_iuran',
        'nama_wajib_pajak',
        'npwp',
        // Kontak
        'fax',
        'website',
        // Data Periodik
        'waktu_penyelenggaraan',
        'bersedia_menerima_bos',
        'akreditasi',
        'sumber_listrik',
        'daya_listrik',
        'akses_internet',
        'latar_belakang',
        'foto_struktur_organisasi',
    ];

    protected $casts = [
        'tanggal_sk_pendirian' => 'date',
        'tanggal_sk_izin_operasional' => 'date',
        'memungut_iuran' => 'boolean',
        'bersedia_menerima_bos' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::updating(function (PkbmProfile $profile) {
            if ($profile->isDirty('logo')) {
                $originalLogo = $profile->getOriginal('logo');
                if ($originalLogo) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($originalLogo);
                }
            }
        });

        static::deleting(function (PkbmProfile $profile) {
            if ($profile->logo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($profile->logo);
            }
        });
    }
}
