<?php

namespace App\Livewire\RealEstate;

use App\Enums\Status;
use App\Models\RealEstate\RealEstateAnnouncement;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    #[Layout('layouts.user')]

    public RealEstateAnnouncement $announcement;

    public function render()
    {
        if ($this->announcement->status == Status::published) {
            return view('livewire.real-estate.show');
        }
        return view('livewire.components.not-found');
    }
}
