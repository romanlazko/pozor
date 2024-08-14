<?php

namespace App\AttributeType;

use App\Models\Feature;
use Filament\Forms\Get;
use Filament\Forms\Components\Toggle as ComponentsToggle;
use Filament\Support\Components\ViewComponent;
use Illuminate\Contracts\Database\Query\Builder;

class Toggle extends BaseAttributeType
{
    protected function getQuery($query) : Builder
    {
        $query->whereHas('features', function ($query) {
            $query->where('attribute_id', $this->attribute->id)->where('translated_value->original', $this->data[$this->attribute->name]);
        });

        return $query;
    }

    public function getValueByFeature(Feature $feature = null) : ?string
    {
        return $this->attribute->label;
    }

    protected function getFilamentFilterComponent(Get $get = null): ?ViewComponent
    {
        return ComponentsToggle::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->columnSpanFull()
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->hidden(fn (Get $get) => $this->isHidden($get));
    }

    protected function getFilamentCreateComponent(Get $get = null): ?ViewComponent
    {
        return ComponentsToggle::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->live();
    }
}