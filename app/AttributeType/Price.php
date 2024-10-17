<?php

namespace App\AttributeType;

use App\Models\Feature;
use Filament\Forms\Components\Grid;
use Filament\Forms\Get;
use Filament\Forms\Components\TextInput as ComponentsTextInput;
use Filament\Support\Components\ViewComponent;
use Filament\Forms\Components\Select as ComponentsSelect;

class Price extends Between
{
    public function getValueByFeature(Feature $feature = null) : ?string
    {
        return $feature->translated_value['original'] . ' ' . $feature->attribute_option?->name;
    }

    protected function schema(): array
    {
        return [
            'attribute_id' => $this->attribute->id,
            'attribute_option_id' => $this->data[$this->attribute->name]['currency'],
            'translated_value' => [
                'original' => $this->data[$this->attribute->name]['amount']
            ],
        ];
    }

    protected function getFilamentCreateComponent(Get $get = null): ?ViewComponent
    {   
        return Grid::make()
            ->schema([
                ComponentsTextInput::make('attributes.'.$this->attribute->name.'.amount')
                    ->label($this->attribute->label)
                    ->numeric()
                    ->required($this->attribute->is_required)
                    ->columnSpan(['default' => 'full', 'md' => 2]),
                ComponentsSelect::make('attributes.'.$this->attribute->name.'.currency')
                    ->label(__('filament.labels.currency'))
                    ->options($this->attribute->attribute_options->pluck('name', 'id'))
                    ->required($this->attribute->is_required)
                    ->columnSpan(['default' => 'full', 'md' => 1]),
            ])
            ->columns(3);
    }
}