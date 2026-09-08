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

    public function badgeStyle(): string
    {
        return match ($this) {
            self::NEW => 'background-color: #fee2e2; color: #dc2626; border: 1px solid #fca5a5;',
            self::READ => 'background-color: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd;',
            self::CONTACTED => 'background-color: #fef3c7; color: #d97706; border: 1px solid #fde68a;',
            self::CLOSED => 'background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
