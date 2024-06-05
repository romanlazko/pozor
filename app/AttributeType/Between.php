<?php

namespace App\AttributeType;

use Filament\Forms\Components\Grid;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Guava\FilamentClusters\Forms\Cluster;
use Filament\Forms\Components\TextInput;

class Between extends BaseAttributeType
{
    public function apply($query)
    {
        $max = $this->data[$this->attribute->name]['max'];
        $min = $this->data[$this->attribute->name]['min'];

        $query->when(!empty($min) OR !empty($max), function ($query) use ($min, $max){
            $query->whereHas('features', function ($query) use ($min, $max){
                $query->where('attribute_id', $this->attribute->id)
                    ->when(!empty($min), fn ($query) => $query->where('translated_value->original', '>=', (integer)$min))
                    ->when(!empty($max), fn ($query) => $query->where('translated_value->original', '<=', (integer)$max));
            });
        });

        return $query;
    }

    public function getFilterComponent(Get $get = null)
    {   
        return Cluster::make([
            TextInput::make('attributes.'.$this->attribute->name.'.min')
                ->placeholder('min')
                ->numeric()
                ->default(''),
            TextInput::make('attributes.'.$this->attribute->name.'.max')
                ->placeholder('max')
                ->numeric()
                ->default(''),
            ])
            ->label($this->attribute->label)
            ->columnSpanFull()
            ->columns(['default' => 2])
            ->visible(fn (Get $get) => $this->isVisible($get));
    }
}