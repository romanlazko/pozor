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

class Price extends BaseAttributeType
{
    public function apply($query)
    {
        $max = $this->data[$this->attribute->name]['max'] ?? null;
        $min = $this->data[$this->attribute->name]['min'] ?? null;

        $query->when(!empty($min) OR !empty($max), function ($query) use ($min, $max){
            $query->whereHas('features', function ($query) use ($min, $max){
                $query->where('attribute_id', $this->attribute->id)
                    ->when(!empty($min), fn ($query) => $query->where('translated_value->original->amount', '>=', (integer)$min))
                    ->when(!empty($max), fn ($query) => $query->where('translated_value->original->amount', '<=', (integer)$max));
            });
        });

        return $query;
    }

    public function getValueByFeature(Feature $feature = null)
    {
        $value = $feature->translated_value[app()->getLocale()] ?? $feature->translated_value['original'] ?? [];

        return ($value['amount'] ?? "") . " " . ($value['currency'] ?? "");
    }

    public function create()
    {
        return [
            'attribute_id' => $this->attribute->id,
            'translated_value'        => [
                'original' => [
                    'amount' => $this->data[$this->attribute->name]['amount'],
                    'currency'   => $this->data[$this->attribute->name]['currency']
                ]
            ],
        ];
    }

    public function getCreateComponent(Get $get = null)
    {
        return Cluster::make([
                ComponentsTextInput::make('attributes.'.$this->attribute->name.'.amount')
                    ->required($this->attribute->required)
                    ->numeric()
                    ->columnSpan(2),
                Select::make('attributes.'.$this->attribute->name.'.currency')
                    ->options(Currency::class)
                    ->required($this->attribute->required)
                    ->columnSpan(1)
            ])
            ->label($this->attribute->label)
            ->columnSpanFull()
            ->columns(['default' => 3, 'sm' => 3, 'md' => 3, 'lg' => 3, 'xl' => 3, 'xxl' => 3])
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->hidden(fn (Get $get) => $this->isHidden($get));
        
    }

    public function getFilterComponent(Get $get = null)
    {   
        return Cluster::make([
            ComponentsTextInput::make('attributes.'.$this->attribute->name.'.min')
                ->placeholder('min')
                ->numeric()
                ->default(''),
            ComponentsTextInput::make('attributes.'.$this->attribute->name.'.max')
                ->placeholder('max')
                ->numeric()
                ->default(''),
            ])
            ->label($this->attribute->label)
            ->columnSpanFull()
            ->columns(['default' => 2])
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->hidden(fn (Get $get) => $this->isHidden($get));
    }
}