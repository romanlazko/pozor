<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Sort: string implements HasLabel
{
    case newest = "newest";
    case oldest = 'oldest';
    case cheapest = 'most_cheaper';
    case mostExpensive = 'most_expensive';

    public function orderBy(): string
    {
        return match ($this) {
            self::newest => 'created_at',
            self::oldest => 'created_at',
            self::cheapest => 'current_price',
            self::mostExpensive => 'current_price',
            default => 'created_at',
        };
    }

    public function type(): string
    {
        return match ($this) {
            self::newest => 'desc',
            self::oldest => 'asc',
            self::cheapest => 'asc',
            self::mostExpensive => 'desc',
            default => 'desc',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::newest => 'Newest',
            self::oldest => 'Oldest',
            self::cheapest => 'Cheapest',
            self::mostExpensive => 'Most Expensive',
            default => 'Newest',
        };
    }
}
