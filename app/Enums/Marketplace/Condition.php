<?php

namespace App\Enums\Marketplace;

enum Condition: int
{
    case new = 1;
    case used = 2;
    

    public function trans($lang = null)
    {
        return __('conditions.marketplace.'.$this->name, [], $lang);
    }
}