<?php

namespace App\AttributeType;

use App\Models\Feature;
use Filament\Forms\Components\Grid;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Guava\FilamentClusters\Forms\Cluster;
use Filament\Forms\Components\TextInput;

class From extends BaseAttributeType
{
    public function apply($query)
    {
        $query->whereHas('features', function ($query) {
            $query->where('attribute_id', $this->attribute->id)->where('translated_value->original->to', '>=', (integer)$this->data[$this->attribute->name]);
        });

        return $query;
    }


    public function getValueByFeature(Feature $feature = null)
    {
        $value = $feature->translated_value[app()->getLocale()] ?? $feature->translated_value['original'] ?? [];

        return ($value['from'] ?? "") . " - " . ($value['to'] ?? "");
    }

    public function create()
    {
        return [
            'attribute_id' => $this->attribute->id,
            'translated_value'        => [
                'original' => [
                    'from' => $this->data[$this->attribute->name]['from'],
                    'to'   => $this->data[$this->attribute->name]['to']
                ]
            ],
        ];
    }

    public function getFilterComponent(Get $get = null)
    {   
        return TextInput::make('attributes.'.$this->attribute->name)
                ->placeholder(__('from'))
                ->numeric()
                ->default('')
                ->label($this->attribute->label)
                ->columnSpanFull()
                ->visible(fn (Get $get) => $this->isVisible($get))
                ->hidden(fn (Get $get) => $this->isHidden($get));
    }

    public function getCreateComponent(Get $get = null)
    {
        return Cluster::make([
            TextInput::make('attributes.'.$this->attribute->name.'.from')
                ->placeholder(__('from'))
                ->numeric()
                ->default(''),
            TextInput::make('attributes.'.$this->attribute->name.'.to')
                ->placeholder(__('to'))
                ->numeric()
                ->default(''),
            ])
            ->label($this->attribute->label)
            ->columnSpanFull()
            ->columns(['default' => 2])
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->hidden(fn (Get $get) => $this->isHidden($get))
            ->required($this->attribute->required);
    }
}