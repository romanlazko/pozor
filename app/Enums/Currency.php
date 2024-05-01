<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Currency: string implements HasLabel
{
    case czk = 'CZK';
    case usd = 'USD';
    case eur = 'EUR';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}