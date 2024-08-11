<?php

namespace App\AttributeType;

use Filament\Forms\Get;
use Filament\Support\Components\ViewComponent;
use Illuminate\Contracts\Database\Query\Builder;

class BaseAttributeType extends AbstractAttributeType
{
    protected function getQuery($query) : Builder
    {
        return $query;
    }

    protected function getFeatureValue(null|string|array $translated_value = null): ?string
    {
        if (is_array($translated_value)) {
            return implode('-', array_filter($translated_value));
        }

        return $translated_value;
    }

    protected function getFilamentCreateComponent(Get $get = null): ?ViewComponent
    {
        return null;
    }

    protected function getFilamentFilterComponent(Get $get = null): ?ViewComponent
    {
        return null;
    }
}