<?php

namespace App\AttributeType;

use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput as ComponentsTextInput;
use Filament\Forms\Get;
use Filament\Support\Enums\VerticalAlignment;

class Search extends BaseAttributeType
{
    public function apply($query)
    {
        $query->whereHas('features', fn ($query) =>
            $query->where('attribute_id', $this->attribute->id)->whereRaw('LOWER(translated_value) LIKE ?', ['%' . mb_strtolower($this->data[$this->attribute->name]) . '%'])
                ->when($this->data['full_text_search'], fn ($query) => $query->orWhere(fn ($query) =>
                    $query->whereRaw('LOWER(translated_value) LIKE ?', ['%' . mb_strtolower($this->data[$this->attribute->name]) . '%'])
                ))
            );

        return $query;
    }

    public function getFilterComponent(Get $get = null)
    {
        return Grid::make(1)
            ->schema([
                ComponentsTextInput::make('attributes.'.$this->attribute->name)
                    ->label(__('Search'))
                    ->columnSpanFull(),
                Checkbox::make('attributes.full_text_search')
                    ->label(__('Full text search')),
                
            ]);
    }
}