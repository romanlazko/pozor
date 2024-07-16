<?php

namespace App\AttributeType;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select as ComponentsSelect;
use Filament\Forms\Components\Textarea as ComponentsTextarea;
use Filament\Forms\Components\TextInput as ComponentsTextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Guava\FilamentClusters\Forms\Cluster;
use Filament\Forms\Components\ToggleButtons as ComponentsToggleButtons;
use Filament\Support\Components\ViewComponent;

class TextArea extends BaseAttributeType
{
    public function apply($query)
    {
        $query->whereHas('features', function ($query) {
            $query->where('attribute_id', $this->attribute->id)->where('attribute_option_id', $this->data[$this->attribute->name]);
        });

        return $query;
    }

    public function getFilamentCreateComponent(Get $get = null): ?ViewComponent
    {
        return ComponentsTextarea::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->autosize()
            ->rows(6)
            ->columnSpan(['default' => 'full', 'sm' => $this->attribute->column_span])
            ->columnStart(['default' => '1', 'sm' => $this->attribute->column_start])
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->hidden(fn (Get $get) => $this->isHidden($get))
            ->required($this->attribute->required);
    }
}