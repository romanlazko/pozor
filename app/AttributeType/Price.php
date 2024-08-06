<?php

namespace App\AttributeType;

use App\Enums\Currency;
use App\Models\Feature;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput as ComponentsTextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\Components\ViewComponent;
use Guava\FilamentClusters\Forms\Cluster;

class Price extends BaseAttributeType
{
    public function apply($query)
    {
        $from = $this->data[$this->attribute->name]['from'] ?? null;
        $to = $this->data[$this->attribute->name]['to'] ?? null;

        $query->when(!empty($from) OR !empty($to), function ($query) use ($to, $from){
            $query->whereHas('features', function ($query) use ($to, $from){
                $query->where('attribute_id', $this->attribute->id)
                    ->when(!empty($from), fn ($query) => $query->where('translated_value->original->amount', '>=', (integer) $from))
                    ->when(!empty($to), fn ($query) => $query->where('translated_value->original->amount', '<=', (integer) $to));
            });
        });

        return $query;
    }

    public function getValueByFeature(Feature $feature = null)
    {
        $value = $feature->translated_value[app()->getLocale()] ?? $feature->translated_value['original'] ?? [];

        return ($value['amount'] ?? "") . " " . ($value['currency'] ?? "");
    }

    public function schema(): array
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

    public function getFilamentCreateComponent(Get $get = null): ?ViewComponent
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
                    ->placeholder(__('filament.labels.currency')),
            ])
            ->label($this->attribute->label)
            ->columnSpanFull()
            ->columns(['default' => 3, 'sm' => 3, 'md' => 3, 'lg' => 3, 'xl' => 3, 'xxl' => 3])
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->hidden(fn (Get $get) => $this->isHidden($get));
        
    }

    public function getFilamentFilterComponent(Get $get = null): ?ViewComponent
    {   
        return Cluster::make([
            ComponentsTextInput::make('attributes.'.$this->attribute->name.'.from')
                ->placeholder(__('filament.placeholders.from'))
                ->numeric()
                ->default(''),
            ComponentsTextInput::make('attributes.'.$this->attribute->name.'.to')
                ->placeholder(__('filament.placeholders.to'))
                ->numeric()
                ->default('')
                // ->extraAttributes(['name' => 'attributes.'.$this->attribute->name.'.to']),
            ])
            ->label($this->attribute->label)
            ->columnSpanFull()
            ->columns(['default' => 2])
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->hidden(fn (Get $get) => $this->isHidden($get));
    }
}