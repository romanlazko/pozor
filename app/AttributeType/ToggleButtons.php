<?php

namespace App\AttributeType;

use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Components\ToggleButtons as ComponentsToggleButtons;
use Filament\Support\Components\ViewComponent;

class ToggleButtons extends BaseAttributeType
{
    public function apply($query)
    {
        if ($attribute_option = $this->attribute->attribute_options?->where('id', $this->data[$this->attribute->name] ?? null)->first() AND $attribute_option?->is_null) {
            return $query;
        }

        return $query->whereHas('features', function ($query) {
            $query->where('attribute_id', $this->attribute->id)->where('attribute_option_id', $this->data[$this->attribute->name]);
        });
    }

    public function getFilamentFilterComponent(Get $get = null): ?ViewComponent
    {
        return ComponentsToggleButtons::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->options($this->attribute->attribute_options?->pluck('name', 'id'))
            ->inline($this->attribute->is_grouped ?? true)
            ->live()
            ->columnSpanFull()
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->hidden(fn (Get $get) => $this->isHidden($get))
            ->afterStateHydrated(function (Get $get, Set $set) {
                if ($get('attributes.'.$this->attribute->name) == null) {
                    $set('attributes.'.$this->attribute->name, $this->attribute->attribute_options?->firstWhere('is_default', true)?->id);
                }
            });
    }

    public function getFilamentCreateComponent(Get $get = null): ?ViewComponent
    {
        return ComponentsToggleButtons::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->options($this->attribute->attribute_options->pluck('name', 'id'))
            ->inline($this->attribute->is_grouped ?? true)
            ->live()
            ->columnSpan(['default' => 'full', 'sm' => $this->attribute->column_span])
            ->columnStart(['default' => '1', 'sm' => $this->attribute->column_start])
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->hidden(fn (Get $get) => $this->isHidden($get))
            ->required($this->attribute->required);
    }
}