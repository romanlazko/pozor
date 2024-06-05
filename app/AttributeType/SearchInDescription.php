<?php

namespace App\AttributeType;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput as ComponentsTextInput;
use Filament\Forms\Get;

class SearchInDescription extends BaseAttributeType
{
    public function apply($query)
    {
        $query->whereHas('features', fn ($query) =>
            $query->whereRaw('LOWER(translated_value) LIKE ?', ['%' . mb_strtolower($this->data[$this->attribute->name]) . '%'])
        );
        
        return $query;
    }

    public function getFilterComponent(Get $get = null)
    {
        return Checkbox::make('attributes.search_in_description')->columnSpanFull();
    }
}