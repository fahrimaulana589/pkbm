<?php

namespace App\Enums;

enum PendaftarStatus: string
{
    case TERDAFTAR = 'terdaftar';
    case DIPROSES = 'diproses';
    case DITERIMA = 'diterima';
    case DITOLAK = 'ditolak';

    public function label(): string
    {
        return match ($this) {
            self::TERDAFTAR => 'Terdaftar',
            self::DIPROSES => 'Diproses',
            self::DITERIMA => 'Diterima',
            self::DITOLAK => 'Ditolak',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::TERDAFTAR => 'info',
            self::DIPROSES => 'warning',
            self::DITERIMA => 'success',
            self::DITOLAK => 'error',
        };
    }
}
