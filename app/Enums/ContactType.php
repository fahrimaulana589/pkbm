<?php

namespace App\Enums;

enum ContactType: string
{
    case TEXT = 'text';
    case LINK = 'link';
    case MAP = 'map';
    case PHONE = 'phone';
    case EMAIL = 'email';
    case WHATSAPP = 'whatsapp';
    case ADDRESS = 'address';
    case SOCIAL = 'social';

    public function label(): string
    {
        return match ($this) {
            self::TEXT => 'Text (Biasa)',
            self::LINK => 'Link (URL)',
            self::MAP => 'Map (Link Peta/Embed)',
            self::PHONE => 'Telepon',
            self::EMAIL => 'Email',
            self::WHATSAPP => 'WhatsApp',
            self::ADDRESS => 'Alamat',
            self::SOCIAL => 'Sosial Media',
        };
    }
}
