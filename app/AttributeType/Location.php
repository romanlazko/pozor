<?php

namespace App\AttributeType;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select as ComponentsSelect;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Guava\FilamentClusters\Forms\Cluster;
use Filament\Forms\Components\TextInput;
use Igaster\LaravelCities\Geo;
use Illuminate\Support\Facades\Cache;

class Location extends BaseAttributeType
{
    private $countries;

    public function __construct(public $attribute, public $data = [])
    {
        $this->countries = Cache::rememberForever('countries', fn () => Geo::select('name', 'country')->where('level', 'PCLI')->get());

        parent::__construct($attribute, $data);
    }

    public function apply($query)
    {
        $query->whereHas('geo', function ($query) {
            $query->when($location = Geo::find($this->data['geo_id']), fn ($query) => 
                $query->radius($location->latitude, $location->longitude, (integer) $this->data['radius'] ?? 30)
            );
        });

        return $query;
    }

    public function getFilterComponent(Get $get = null)
    {
        if (!$this->attribute->filterable) return null;

        return Grid::make(2)
            ->schema([
                ComponentsSelect::make('country')
                    ->label(__('filament.labels.country'))
                    ->options($this->countries->pluck('name', 'country'))
                    ->searchable()
                    ->afterStateUpdated(function (Set $set) {
                        $set('attributes.geo_id', null);
                    })
                    ->placeholder(__('filament.labels.country'))
                    ->default('CZ')
                    ->live(),
                ComponentsSelect::make('attributes.geo_id')
                    ->label(__('filament.labels.city'))
                    ->searchable()
                    ->preload()
                    ->options(fn (Get $get) => Geo::where('country', $get('country') ?? 'CZ')?->pluck('name', 'id'))
                    ->getSearchResultsUsing(function (string $search, Get $get) {
                        return Geo::where('country', $get('country') ?? 'CZ')
                            ->whereRaw('LOWER(alternames) LIKE ?', ['%' . mb_strtolower($search) . '%'])
                            ->pluck('name', 'id');
                    })
                    ->live()
                    ->placeholder(__('filament.labels.city')),
                ComponentsSelect::make('attributes.radius')
                    ->hiddenLabel()
                    ->options([
                        10 => '10 km',
                        20 => '20 km',
                        30 => '30 km',
                        40 => '40 km',
                        50 => '50 km',
                        60 => '60 km',
                        70 => '70 km',
                    ])
                    ->hidden(fn (Get $get) => $get('attributes.geo_id') == null)
                    ->placeholder(__('filament.labels.radius')),
            ]);
    }

    public function getCreateComponent(Get $get = null)
    {
        return Grid::make(2)
            ->schema([
                ComponentsSelect::make('country')
                    ->label(__('filament.labels.country'))
                    ->options($this->countries->pluck('name', 'country'))
                    ->searchable()
                    ->afterStateUpdated(function (Set $set) {
                        $set('geo_id', null);
                    })
                    ->placeholder(__('filament.labels.country'))
                    ->default('CZ')
                    ->live(),
                ComponentsSelect::make('geo_id')
                    ->label(__('filament.labels.city'))
                    ->searchable()
                    ->preload()
                    ->options(fn (Get $get) => Geo::where('country', $get('country') ?? 'CZ')?->pluck('name', 'id'))
                    ->getSearchResultsUsing(function (string $search, Get $get) {
                        return Geo::where('country', $get('country') ?? 'CZ')
                            ->whereRaw('LOWER(alternames) LIKE ?', ['%' . mb_strtolower($search) . '%'])
                            ->pluck('name', 'id');
                    })
                    ->live()
                    ->placeholder(__('filament.labels.city'))
            ]);
    }
}