<?php

namespace App\AttributeType;

use Filament\Forms\Components\TextInput as ComponentsTextInput;
use Filament\Forms\Get;
use Filament\Support\Components\ViewComponent;

class TextInput extends BaseAttributeType
{
    protected function getFilamentCreateComponent(Get $get = null): ?ViewComponent
    {
        return ComponentsTextInput::make('attributes.'.$this->attribute->name)
                ->label($this->attribute->label)
                ->rules($this->attribute->create_layout['rules'] ?? [])
                ->suffix($this->attribute->suffix)
                ->required($this->attribute->required);
    }

    protected function getFilamentFilterComponent(Get $get = null): ?ViewComponent
    {
        return ComponentsTextInput::make('attributes.'.$this->attribute->name)
                ->label($this->attribute->label)
                ->suffix($this->attribute->suffix);
    }
}