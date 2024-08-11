<?php

namespace App\AttributeType;

use App\Models\Feature;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Grid;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Guava\FilamentClusters\Forms\Cluster;
use Filament\Support\Components\ViewComponent;
use Filament\Forms\Components\TextInput as ComponentsTextInput;
use Illuminate\Contracts\Database\Query\Builder;

class Between extends BaseAttributeType
{
    protected function getQuery($query) : Builder
    {
        $from = $this->data[$this->attribute->name]['from'] ?? null;
        $to = $this->data[$this->attribute->name]['to'] ?? null;

        $query->when(!empty($from) OR !empty($to), function ($query) use ($from, $to){
            $query->whereHas('features', function ($query) use ($from, $to){
                $query->where('attribute_id', $this->attribute->id)
                    ->when(!empty($from), fn ($query) => $query->where('translated_value->original', '>=', (integer)$from))
                    ->when(!empty($to), fn ($query) => $query->where('translated_value->original', '<=', (integer)$to));
            });
        });

        return $query;
    }

    protected function getFilamentFilterComponent(Get $get = null): ?ViewComponent
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
            ->columnSpanFull()
            ->columns(['default' => 2])
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->hidden(fn (Get $get) => $this->isHidden($get));
    }

    protected function getFilamentCreateComponent(Get $get = null): ?ViewComponent
    {   
        return (new TextInput($this->attribute, $this->data))->getFilamentCreateComponent($get);
    }
}