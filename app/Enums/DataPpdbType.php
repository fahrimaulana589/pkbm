<?php

namespace App\Enums;

enum DataPpdbType: string
{
    case TEXT = 'text';
    case NUMBER = 'number';
    case DATE = 'date';
    case FILE = 'file';
    case TEXTAREA = 'textarea';

    public function label(): string
    {
        return match ($this) {
            self::TEXT => 'Teks Singkat (Text)',
            self::NUMBER => 'Angka (Number)',
            self::DATE => 'Tanggal (Date)',
            self::FILE => 'Upload File',
            self::TEXTAREA => 'Teks Panjang (Textarea)',
        };
    }
}
