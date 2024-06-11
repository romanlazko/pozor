<?php

namespace App\AttributeType;

use App\Enums\Currency;
use App\Models\Feature;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput as ComponentsTextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Guava\FilamentClusters\Forms\Cluster;

class PriceFrom extends BaseAttributeType
{
    public function apply($query)
    {
        $query->whereHas('features', function ($query) {
            $query->where('attribute_id', $this->attribute->id)->where('translated_value->original->amount->to', '>=', (integer)$this->data[$this->attribute->name]['min']);
        });

        return $query;
    }


    public function getValueByFeature(Feature $feature = null)
    {
        $value = $feature->translated_value[app()->getLocale()] ?? $feature->translated_value['original'] ?? [];

        return ($value['amount']['from'] ?? "") . " - " . ($value['amount']['to'] ?? "")  . " " . ($value['currency'] ?? "");
    }

    public function create()
    {
        return [
            'attribute_id' => $this->attribute->id,
            'translated_value'        => [
                'original' => [
                    'amount' => [
                        'from' => $this->data[$this->attribute->name]['amount']['from'],
                        'to'   => $this->data[$this->attribute->name]['amount']['to']
                    ],
                    'currency' => $this->data[$this->attribute->name]['currency']
                ]
            ],
        ];
    }

    public function getFilterComponent(Get $get = null)
    {   
        return ComponentsTextInput::make('attributes.'.$this->attribute->name.'.min')
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
            ComponentsTextInput::make('attributes.'.$this->attribute->name.'.amount.from')
                ->placeholder(__('from'))
                ->numeric()
                ->default('')
                ->required($this->attribute->required)
                ->numeric()
                ->columnSpan(2),
            ComponentsTextInput::make('attributes.'.$this->attribute->name.'.amount.to')
                ->placeholder(__('to'))
                ->numeric()
                ->default('')
                ->required($this->attribute->required)
                ->numeric()
                ->columnSpan(2),
            Select::make('attributes.'.$this->attribute->name.'.currency')
                ->options(Currency::class)
                ->required($this->attribute->required)
                ->columnSpan(['default' => 4, 'sm' => 1, 'md' => 1, 'lg' => 1, 'xl' => 1, 'xxl' => 1]),
        ])
        ->label($this->attribute->label)
        ->columnSpanFull()
        ->columns(['default' => 4, 'sm' => 5, 'md' => 5, 'lg' => 5, 'xl' => 5, 'xxl' => 5])
        ->visible(fn (Get $get) => $this->isVisible($get))
        ->hidden(fn (Get $get) => $this->isHidden($get));
    }
}