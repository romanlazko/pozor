<?php

namespace App\AttributeType;

use App\Models\Feature;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Grid;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Guava\FilamentClusters\Forms\Cluster;
use Filament\Forms\Components\TextInput;
use Filament\Support\Components\ViewComponent;

class Between extends BaseAttributeType
{
    protected function apply($query)
    {
        $from = $this->data[$this->attribute->name]['from'];
        $to = $this->data[$this->attribute->name]['to'];

        $query->when(!empty($min) OR !empty($max), function ($query) use ($from, $to){
            $query->whereHas('features', function ($query) use ($from, $to){
                $query->where('attribute_id', $this->attribute->id)
                    ->when(!empty($min), fn ($query) => $query->where('translated_value->original', '>=', (integer)$from))
                    ->when(!empty($max), fn ($query) => $query->where('translated_value->original', '<=', (integer)$to));
            });
        });

        return $query;
    }

    protected function getFilamentFilterComponent(Get $get = null): ?ViewComponent
    {   
        return Cluster::make([
            TextInput::make('attributes.'.$this->attribute->name.'.from')
                ->placeholder(__('filament.placeholders.from'))
                ->numeric()
                ->default(''),
            TextInput::make('attributes.'.$this->attribute->name.'.to')
                ->placeholder(__('filament.placeholders.to'))
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