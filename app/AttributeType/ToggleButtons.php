<?php

namespace App\AttributeType;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select as ComponentsSelect;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Guava\FilamentClusters\Forms\Cluster;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons as ComponentsToggleButtons;

class ToggleButtons extends BaseAttributeType
{
    public function apply($query)
    {
        if ($this->attribute->attribute_options?->find($this->data[$this->attribute->name])->is_null) {
            return $query;
        }

        return $query->whereHas('features', function ($query) {
            $query->where('attribute_id', $this->attribute->id)->where('attribute_option_id', $this->data[$this->attribute->name]);
        });
    }

    public function getFilterComponent(Get $get = null)
    {
        if (!$this->attribute->filterable) return null;
        
        return ComponentsToggleButtons::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->options($this->attribute->attribute_options?->pluck('name', 'id'))
            ->grouped()
            ->live()
            ->columnSpanFull()
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->afterStateHydrated(function (Get $get, Set $set) {
                if ($get('attributes.'.$this->attribute->name) == null) {
                    $set('attributes.'.$this->attribute->name, $this->attribute->attribute_options?->firstWhere('is_default', true)?->id);
                }
            });
    }

    public function getCreateComponent(Get $get = null)
    {
        return ComponentsToggleButtons::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->options($this->attribute->attribute_options->pluck('name', 'id'))
            ->grouped()
            ->live()
            ->columnSpan(['default' => 'full', 'sm' => $this->attribute->column_span])
            ->columnStart(['default' => '1', 'sm' => $this->attribute->column_start])
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->required($this->attribute->required);
    }
}