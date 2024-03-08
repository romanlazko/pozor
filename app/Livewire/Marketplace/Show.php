<?php

namespace App\Livewire\Marketplace;

use App\Enums\Status;
use App\Models\Marketplace\MarketplaceAnnouncement;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    #[Layout('layouts.user')]

    public MarketplaceAnnouncement $announcement;

    public function render()
    {
        if ($this->announcement->status == Status::published) {
            return view('livewire.marketplace.show');
        }
        return view('livewire.components.not-found');
    }
}
