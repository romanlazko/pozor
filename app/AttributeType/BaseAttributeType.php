<?php

namespace App\AttributeType;

use Filament\Forms\Get;
use Filament\Support\Components\ViewComponent;
use Illuminate\Database\Eloquent\Builder;

class BaseAttributeType extends AbstractAttributeType
{
    protected function getSortQuery(Builder $query, $direction = 'asc') : Builder
    {
        return $query->rightJoin('features as announcement_features', function($join) {
            $join->on('announcements.id', '=', 'announcement_features.announcement_id')
                ->where('announcement_features.attribute_id', $this->attribute->id);
        })
        ->orderByRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(announcement_features.translated_value, "$.original")) AS UNSIGNED) ' . $direction);
    }


    protected function getSearchQuery(Builder $query) : Builder
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