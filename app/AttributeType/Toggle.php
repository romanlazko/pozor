<?php

namespace App\AttributeType;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select as ComponentsSelect;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Guava\FilamentClusters\Forms\Cluster;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle as ComponentsToggle;

class Toggle extends BaseAttributeType
{
    public function apply($query)
    {
        $query->whereHas('features', function ($query) {
            $query->where('attribute_id', $this->attribute->id)->where('translated_value->original', $this->data[$this->attribute->name]);
        });

        return $query;
    }

    public function getFilterComponent(Get $get = null)
    {
        if (!$this->attribute->filterable) return null;
        
        return ComponentsToggle::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->columnSpanFull()
            ->visible(fn (Get $get) => $this->isVisible($get));
    }

    public function getCreateComponent(Get $get = null)
    {
        return ComponentsToggle::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->columnSpan(['default' => 'full', 'sm' => $this->attribute->column_span])
            ->columnStart(['default' => '1', 'sm' => $this->attribute->column_start])
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->live();
    }
}