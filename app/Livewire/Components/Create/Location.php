<?php

namespace App\Livewire\Components\Create;

use Igaster\LaravelCities\Geo;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\Component;

use Stevebauman\Location\Facades\Location as CurrentLocation;

class Location extends Component
{
    #[Reactive]
    public $error;
    
    #[Modelable]
    public $location = [];

    public $search = null;

    public $countries;

    public $country;

    public function mount()
    {
        $this->countries = Geo::getCountries();
        
        $this->location = Geo::findName((CurrentLocation::get() ?: null)?->cityName)?->toArray();

        $this->country = $this->location['country'] ?? null;
        $this->search = $this->location['name'] ?? null;
    }

    public function render()
    {
        $cities = Geo::search($this->search)->where('country', $this->country)->limit(30)->get();

        if (($this->location['name'] ?? '') != $this->search OR ($this->location['country'] ?? '') != $this->country) {
            $this->reset('location');
        }

        return view('livewire.components.create.location', compact(
            'cities'
        ));
    }

    public function setLocation($name)
    {
        $this->location = Geo::findName($name)->toArray();
        $this->search = $name;
    }
}
