<?php

namespace App\Enums\Marketplace;

enum Condition: int
{
    case good = 1;
    case bad = 2;
    case used = 3;

    public function trans($lang = null)
    {
        return __('conditions.marketplace.'.$this->name, [], $lang);
    }
}