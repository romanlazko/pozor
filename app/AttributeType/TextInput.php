<?php

namespace App\AttributeType;

use Filament\Forms\Components\TextInput as ComponentsTextInput;
use Filament\Forms\Get;

class TextInput extends BaseAttributeType
{
    public function getCreateComponent(Get $get = null)
    {
        return ComponentsTextInput::make('attributes.'.$this->attribute->name)
                ->label($this->attribute->label)
                ->columnSpan(['default' => 'full', 'sm' => $this->attribute->column_span])
                ->columnStart(['default' => '1', 'sm' => $this->attribute->column_start])
                ->visible(fn (Get $get) => $this->isVisible($get))
                ->hidden(fn (Get $get) => $this->isHidden($get))
                ->required($this->attribute->required)
                ->rules($this->attribute->rules)
                ->suffix($this->attribute->suffix);
    }
}