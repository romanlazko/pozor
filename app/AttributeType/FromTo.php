<?php

namespace App\AttributeType;

use Filament\Forms\Get;
use Guava\FilamentClusters\Forms\Cluster;
use Filament\Forms\Components\TextInput as ComponentsTextInput;
use Filament\Support\Components\ViewComponent;
use Illuminate\Contracts\Database\Query\Builder;

class FromTo extends Between
{
    protected function getQuery($query) : Builder
    {
        $from = $this->data[$this->attribute->name]['from'] ?? null;
        $to = $this->data[$this->attribute->name]['to'] ?? null;

        $query->when(!empty($from), fn ($query) => 
            $query->whereHas('features', fn ($query) =>
                $query->where('attribute_id', $this->attribute->id)
                    ->where('translated_value->original->to', '>=', (integer)$from)
                    ->orWhere('translated_value->original->from', '>=', (integer)$from)
        ))
        ->when(!empty($to), fn ($query) => 
            $query->whereHas('features', fn ($query) =>
                $query->where('attribute_id', $this->attribute->id)
                    ->where('translated_value->original->to', '<=', (integer)$to)
                    ->orWhere('translated_value->original->from', '<=', (integer)$to)
        ));

        return $query;
    }

    protected function getFeatureValue(null|string|array $translated_value = null): ?string
    {
        return implode('-', array_filter([
            'from' => $translated_value['from'],
            'to' => $translated_value['to'],
        ]));
    }

    protected function getFilamentCreateComponent(Get $get = null): ?ViewComponent
    {   
        return Cluster::make([
            ComponentsTextInput::make('attributes.'.$this->attribute->name.'.from')
                ->placeholder(__('filament.placeholders.from'))
                ->numeric()
                ->default(''),
            ComponentsTextInput::make('attributes.'.$this->attribute->name.'.to')
                ->placeholder(__('filament.placeholders.to'))
                ->numeric()
                ->default(''),
            ])
            ->label($this->attribute->label)
            ->columns(['default' => 2]);
    }
}