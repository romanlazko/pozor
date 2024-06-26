<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Facades\App;

enum Sort: string implements HasLabel
{
    case newest = "newest";
    case oldest = 'oldest';
    // case cheapest = 'most_cheaper';
    // case mostExpensive = 'most_expensive';

    public function orderBy(): string
    {
        return match ($this) {
            self::newest => 'created_at',
            self::oldest => 'created_at',
            // self::cheapest => 'current_price',
            // self::mostExpensive => 'current_price',
            default => 'created_at',
        };
    }

    public function type(): string
    {
        return match ($this) {
            self::newest => 'desc',
            self::oldest => 'asc',
            // self::cheapest => 'asc',
            // self::mostExpensive => 'desc',
            default => 'desc',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::newest => match (App::getLocale()) {
                'ru' => 'Самые новые',
                'en' => 'Newest',
                'cs' => 'Najnovejsi',
                default => 'Newest',
            },
            self::oldest => match (App::getLocale()) {
                'ru' => 'Самые старые',
                'en' => 'Oldest',
                'cs' => 'Najstarsi',
                default => 'Oldest',
            },
            self::cheapest => match (App::getLocale()) {
                'ru' => 'Самые дешёвые',
                'en' => 'Cheapest',
                'cs' => 'Najlevnejsi',
                default => 'Cheapest',
            },
            self::mostExpensive => match (App::getLocale()) {
                'ru' => 'Самые дорогие',
                'en' => 'Most Expensive',
                'cs' => 'Najskrátnejsi',
                default => 'Most Expensive',
            },
            default => 'Newest',
        };
    }

    
}
