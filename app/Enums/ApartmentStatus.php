<?php

namespace App\Enums;

enum ApartmentStatus: string
{
    case AVAILABLE = 'available';
    case MAINTENANCE = 'maintenance';
    case RENTED = 'rented';

    public function label(): string
    {
        return match($this) {
            self::AVAILABLE => 'Disponible',
            self::MAINTENANCE => 'En Mantenimiento',
            self::RENTED => 'Arrendado',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::AVAILABLE => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
            self::MAINTENANCE => 'bg-purple-50 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
            self::RENTED => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
        };
    }

    public function headerBgClass(): string
    {
        return match($this) {
            self::AVAILABLE => 'bg-emerald-500',
            self::MAINTENANCE => 'bg-purple-500',
            self::RENTED => 'bg-amber-500',
        };
    }
}
