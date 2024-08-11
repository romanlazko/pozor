<?php

namespace App\AttributeType;

use Filament\Forms\Components\Select as ComponentsSelect;
use Filament\Forms\Get;
use Filament\Support\Components\ViewComponent;
use Illuminate\Contracts\Database\Query\Builder;

class Select extends BaseAttributeType
{
    protected function getQuery($query) : Builder
    {
        $query->whereHas('features', function ($query) {
            $query->where('attribute_id', $this->attribute->id)->when($this->attribute->attribute_options_count > 0, fn ($query) =>
                $query->where('attribute_option_id', $this->data[$this->attribute->name])
            )
            ->when($this->attribute->attribute_options_count == 0, fn ($query) =>
                $query->where('translated_value->original', $this->data[$this->attribute->name])
            );
        });

        return $query;
    }

    protected function getFilamentFilterComponent(Get $get = null): ?ViewComponent
    {
        return ComponentsSelect::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->options($this->attribute->attribute_options?->pluck('name', 'id'))
            ->columnSpanFull()
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->hidden(fn (Get $get) => $this->isHidden($get));
    }

    protected function getFilamentCreateComponent(Get $get = null): ?ViewComponent
    {
        return ComponentsSelect::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->options($this->attribute->attribute_options->pluck('name', 'id'))
            ->required($this->attribute->required);
    }
}