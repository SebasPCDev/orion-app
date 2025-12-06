<?php

namespace App\Enums;

enum UserStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case AVAILABLE = 'available';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Activo',
            self::INACTIVE => 'Inactivo',
            self::AVAILABLE => 'Disponible',
        };
    }
    
    public function badgeClass(): string
    {
        return match($this) {
            self::ACTIVE => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
            self::INACTIVE => 'bg-gray-50 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400',
            self::AVAILABLE => 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
        };
    }
    
    public function icon(): string
    {
        return match($this) {
            self::ACTIVE => 'check-circle',
            self::INACTIVE => 'x-circle',
            self::AVAILABLE => 'user-plus',
        };
    }
    public function value(): string
    {
        return match($this) {
            self::ACTIVE => 'active',
            self::INACTIVE => 'inactive',
            self::AVAILABLE => 'available',
        };
    }
}