<?php

namespace App\Livewire;

use App\Models\Geo;
use Dotswan\MapPicker\Fields\Map;
use Livewire\Component;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Facades\Cache;

class LocationForm extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $locationData;

    public $category;

    public $countries;

    private $defaultCoordinates = [
        'lat' => 50.073658,
        'lng' => 14.418540
    ];

    public function mount($location, $category = null)
    {
        $this->category = $category;
        $this->locationData = $location ?? [];
        $this->countries = Cache::rememberForever('countries', fn () => Geo::select('name', 'country')->where('level', 'PCLI')->get());
    }

    public function location(): Action
    {
        return Action::make('location')
            ->link()
            ->icon('heroicon-o-map-pin')
            ->extraAttributes(['class' => 'cursor-pointer whitespace-nowrap'])
            ->label(Geo::find($this->locationData['geo_id'] ?? null)?->name)
            ->form([
                Section::make()
                    ->schema([
                        Select::make('country')
                            ->label(__('filament.labels.country'))
                            ->options($this->countries->pluck('name', 'country'))
                            ->searchable()
                            ->afterStateUpdated(function (Set $set) {
                                $set('geo_id', null);
                            })
                            ->placeholder(__('filament.labels.country'))
                            ->default('CZ')
                            ->live()
                            ->columnSpan(1),
                        Select::make('geo_id')
                            ->label(__('filament.labels.city'))
                            ->searchable()
                            ->preload()
                            ->options(fn (Get $get) => Geo::where('country', $get('country') ?? 'CZ')->orderBy('level')->pluck('name', 'id'))
                            ->getSearchResultsUsing(function (string $search, Get $get) {
                                return Geo::where('country', $get('country') ?? 'CZ')
                                    ->whereRaw('LOWER(alternames) LIKE ?', ['%' . mb_strtolower($search) . '%'])
                                    ->limit(30)
                                    ->pluck('name', 'id');
                            })
                            ->live()
                            ->placeholder(__('filament.labels.city'))
                            ->afterStateUpdated(function (Set $set, $state, $livewire) {
                                $geo = Geo::find($state);
                                $set('coordinates', ['lat' => $geo->latitude, 'lng' => $geo->longitude]);
                                $livewire->dispatch('refreshMap');
                            })
                            ->columnSpan(1),
                        Map::make('coordinates')
                            ->showMyLocationButton()
                            ->liveLocation(true, true, 5000)
                            ->afterStateUpdated(function (Set $set, $state) {
                                $set('geo_id', Geo::radius($state['lat'], $state['lng'], 10)->first()->id);
                            })
                            ->afterStateHydrated(function (Set $set): void {
                                $set('coordinates', [
                                    'lat' => $this->locationData['coordinates']['lat'] ?? $this->defaultCoordinates['lat'], 
                                    'lng' => $this->locationData['coordinates']['lng'] ?? $this->defaultCoordinates['lng']
                                ]);
                            })
                            ->zoom(11)
                            ->columnSpanFull(),
                        Select::make('radius')
                            ->label(__('filament.labels.radius'))
                            ->options([
                                10 => '10 km',
                                20 => '20 km',
                                30 => '30 km',
                                40 => '40 km',
                                50 => '50 km',
                                60 => '60 km',
                                70 => '70 km',
                            ])
                            ->afterStateHydrated(function (Set $set) {
                                $set('radius', $this->locationData['radius'] ?? 30);
                            })
                            ->selectablePlaceholder(false)
                            ->placeholder(__('filament.labels.radius'))
                    ])
                    ->columns(2),
            ])
            ->slideOver()
            ->action(fn (array $data) => 
                $this->redirectRoute('announcement.search', ['location' => $data, 'category' => $this->category?->slug])
            );
    }

    public function render()
    {
        return view('livewire.location-form');
    }
}
