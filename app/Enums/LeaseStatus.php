<?php

namespace App\Enums;

enum LeaseStatus: string
{
    case ACTIVE = 'active';
    case COMPLETED = 'completed';
    case TERMINATED = 'terminated';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Activo',
            self::COMPLETED => 'Completado',
            self::TERMINATED => 'Terminado',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::ACTIVE => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
            self::COMPLETED => 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
            self::TERMINATED => 'bg-gray-50 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::ACTIVE => 'check-circle',
            self::COMPLETED => 'flag',
            self::TERMINATED => 'x-circle',
        };
    }
}
