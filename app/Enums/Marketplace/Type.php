<?php

namespace App\Enums\Marketplace;

enum Type: int
{
    case sell = 1;
    case buy = 2;

    public function hashTag()
    {
        return match ($this) {
            self::sell => '#продам',
            self::buy => '#куплю',
        };
    }
}