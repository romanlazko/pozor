<?php

namespace App\AttributeType;

use App\Models\Feature;
use Filament\Forms\Get;
use Filament\Forms\Components\Toggle as ComponentsToggle;
use Filament\Support\Components\ViewComponent;
use Illuminate\Database\Eloquent\Builder;

class Toggle extends BaseAttributeType
{
    protected function getSearchQuery(Builder $query) : Builder
    {
        // $query->whereHas('features', function ($query) {
            $query->where('attribute_id', $this->attribute->id)->where('translated_value->original', $this->data[$this->attribute->name]);
        // });

        return $query;
    }

    public function getValueByFeature(Feature $feature = null) : ?string
    {
        return $this->attribute->label;
    }

    protected function getFilamentFilterComponent(Get $get = null): ?ViewComponent
    {
        return ComponentsToggle::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label);
    }

    protected function getFilamentCreateComponent(Get $get = null): ?ViewComponent
    {
        return ComponentsToggle::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->live()
            ->required($this->attribute->required);
    }
}