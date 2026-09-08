<?php

namespace App\Enums;

enum MilestoneStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case DELAYED = 'delayed';
    case ON_HOLD = 'on_hold';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETED => 'Completed',
            self::DELAYED => 'Delayed',
            self::ON_HOLD => 'On Hold',
        };
    }

    public function badgeStyle(): string
    {
        return match ($this) {
            self::PENDING => 'background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;',
            self::IN_PROGRESS => 'background-color: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;',
            self::COMPLETED => 'background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;',
            self::DELAYED => 'background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;',
            self::ON_HOLD => 'background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a;',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
