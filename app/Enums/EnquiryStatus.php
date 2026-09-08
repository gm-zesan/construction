<?php

namespace App\Enums;

enum EnquiryStatus: string
{
    case NEW = 'new';
    case READ = 'read';
    case CONTACTED = 'contacted';
    case CLOSED = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::NEW => 'New',
            self::READ => 'Read',
            self::CONTACTED => 'Contacted',
            self::CLOSED => 'Closed',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
