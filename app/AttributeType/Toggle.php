<?php

namespace App\AttributeType;

use App\Models\Feature;
use Filament\Forms\Get;
use Filament\Forms\Components\Toggle as ComponentsToggle;
use Filament\Support\Components\ViewComponent;

class Toggle extends BaseAttributeType
{
    public function apply($query)
    {
        $query->whereHas('features', function ($query) {
            $query->where('attribute_id', $this->attribute->id)->where('translated_value->original', $this->data[$this->attribute->name]);
        });

        return $query;
    }

    public function getValueByFeature(Feature $feature = null)
    {
        return $this->attribute->label;
    }

    public function getFilamentFilterComponent(Get $get = null): ?ViewComponent
    {
        return ComponentsToggle::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->columnSpanFull()
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->hidden(fn (Get $get) => $this->isHidden($get));
    }

    public function getFilamentCreateComponent(Get $get = null): ?ViewComponent
    {
        return ComponentsToggle::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->columnSpan(['default' => 'full', 'sm' => $this->attribute->column_span])
            ->columnStart(['default' => '1', 'sm' => $this->attribute->column_start])
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->hidden(fn (Get $get) => $this->isHidden($get))
            ->live();
    }
}