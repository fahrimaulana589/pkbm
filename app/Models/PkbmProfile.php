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
    ];
}
