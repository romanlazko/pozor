<?php

namespace App\AttributeType;

use Filament\Forms\Components\CheckboxList as ComponentsCheckboxList;
use Filament\Forms\Get;
use Filament\Support\Components\ViewComponent;
use Illuminate\Database\Eloquent\Builder;

class CheckboxList extends BaseAttributeType
{
    protected function getSearchQuery(Builder $query) : Builder
    {
        // $query->whereHas('features', function ($query) {
        return $query->where('attribute_id', $this->attribute->id)->when($this->attribute->attribute_options->count() > 0, fn ($query) =>
                $query->whereIn('attribute_option_id', $this->data[$this->attribute->name])
            )
            ->when($this->attribute->attribute_options->count() == 0, fn ($query) =>
                $query->whereIn('translated_value->original', $this->data[$this->attribute->name])
            );
        // });

        // return $query;
    }

    protected function getFilamentFilterComponent(Get $get = null): ?ViewComponent
    {
        return ComponentsCheckboxList::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->options($this->attribute->attribute_options?->pluck('name', 'id'));
    }
}