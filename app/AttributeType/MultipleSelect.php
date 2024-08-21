<?php

namespace App\AttributeType;

use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Support\Components\ViewComponent;
use Illuminate\Database\Eloquent\Builder;

class MultipleSelect extends BaseAttributeType
{
    protected function getSearchQuery(Builder $query) : Builder
    {
        $query->whereHas('features', function ($query) {
            $query->where('attribute_id', $this->attribute->id)->when($this->attribute->attribute_options_count > 0, fn ($query) =>
                $query->whereIn('attribute_option_id', $this->data[$this->attribute->name])
            )
            ->when($this->attribute->attribute_options_count == 0, fn ($query) =>
                $query->whereIn('translated_value->original', $this->data[$this->attribute->name])
            );
        });

        return $query;
    }

    protected function getFilamentFilterComponent(Get $get = null): ?ViewComponent
    {
        return Select::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->options($this->attribute->attribute_options?->pluck('name', 'id'))
            ->multiple()
            ->searchable(false);
    }
}