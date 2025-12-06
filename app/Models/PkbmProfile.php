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
