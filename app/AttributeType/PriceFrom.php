<?php

namespace App\AttributeType;

use App\Enums\Currency;
use App\Models\Feature;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput as ComponentsTextInput;
use Filament\Forms\Get;
use Filament\Support\Components\ViewComponent;
use Guava\FilamentClusters\Forms\Cluster;

class PriceFrom extends BaseAttributeType
{
    public function apply($query)
    {
        $query->whereHas('features', function ($query) {
            $query->where('attribute_id', $this->attribute->id)->where('translated_value->original->amount->to', '>=', (integer) $this->data[$this->attribute->name]['from']);
        });

        return $query;
    }


    public function getValueByFeature(Feature $feature = null)
    {
        $value = $feature->translated_value[app()->getLocale()] ?? $feature->translated_value['original'] ?? [];

        return ($value['amount']['from'] ?? "") . " - " . ($value['amount']['to'] ?? "")  . " " . ($value['currency'] ?? "");
    }

    public function getCreateSchema(): array
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

    public function getFilamentFilterComponent(Get $get = null): ?ViewComponent
    {   
        return ComponentsTextInput::make('attributes.'.$this->attribute->name.'.from')
                ->placeholder(__('filament.placeholders.from'))
                ->numeric()
                ->default('')
                ->label($this->attribute->label)
                ->columnSpanFull()
                ->visible(fn (Get $get) => $this->isVisible($get))
                ->hidden(fn (Get $get) => $this->isHidden($get));
    }

    public function getFilamentCreateComponent(Get $get = null): ?ViewComponent
    {
        return Grid::make(2)
            ->schema([
                Cluster::make([
                        ComponentsTextInput::make('attributes.'.$this->attribute->name.'.amount.from')
                            ->placeholder(__('filament.placeholders.from'))
                            ->numeric()
                            ->default('')
                            ->required($this->attribute->required)
                            ->numeric()
                            ->columnSpan(1),
                        ComponentsTextInput::make('attributes.'.$this->attribute->name.'.amount.to')
                            ->placeholder(__('filament.placeholders.to'))
                            ->numeric()
                            ->default('')
                            ->required($this->attribute->required)
                            ->numeric()
                            ->columnSpan(1),
                    ])
                    ->label($this->attribute->label)
                    ->columnSpan(2)
                    ->columns(['default' => 2, 'sm' => 2, 'md' => 2, 'lg' => 2, 'xl' => 2, 'xxl' => 2])
                    ->visible(fn (Get $get) => $this->isVisible($get))
                    ->hidden(fn (Get $get) => $this->isHidden($get)),

                Select::make('attributes.'.$this->attribute->name.'.currency')
                    ->options(Currency::class)
                    ->hiddenLabel()
                    ->placeholder(__('filament.placeholders.currency'))
                    ->required($this->attribute->required)
                    ->columnSpan(['default' => 2, 'sm' => 2, 'md' => 1, 'lg' => 1, 'xl' => 1, 'xxl' => 1]),
            ]);
    }
}