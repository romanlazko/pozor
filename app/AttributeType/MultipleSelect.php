<?php

namespace App\AttributeType;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Guava\FilamentClusters\Forms\Cluster;
use Filament\Forms\Components\TextInput;
use Filament\Support\Components\ViewComponent;

class MultipleSelect extends BaseAttributeType
{
    public function apply($query)
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

    public function getFilamentFilterComponent(Get $get = null): ?ViewComponent
    {
        return Select::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->options($this->attribute->attribute_options?->pluck('name', 'id'))
            ->columnSpanFull()
            ->multiple()
            ->searchable(false)
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->hidden(fn (Get $get) => $this->isHidden($get));
    }
}