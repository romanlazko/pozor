<?php

namespace App\AttributeType;

use Filament\Forms\Components\Select as ComponentsSelect;
use Filament\Forms\Get;

class Select extends BaseAttributeType
{
    public function apply($query)
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

    public function getFilterComponent(Get $get = null)
    {
        if (!$this->attribute->filterable) return null;

        return ComponentsSelect::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->options($this->attribute->attribute_options?->pluck('name', 'id'))
            ->columnSpanFull()
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->hidden(fn (Get $get) => $this->isHidden($get));
    }

    public function getCreateComponent(Get $get = null)
    {
        return ComponentsSelect::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->options($this->attribute->attribute_options->pluck('name', 'id'))
            ->columnSpan(['default' => 'full', 'sm' => $this->attribute->column_span])
            ->columnStart(['default' => '1', 'sm' => $this->attribute->column_start])
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->hidden(fn (Get $get) => $this->isHidden($get))
            ->required($this->attribute->required);
    }
}