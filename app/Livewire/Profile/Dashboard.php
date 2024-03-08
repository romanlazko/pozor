<?php

namespace App\Livewire\Profile;

use App\Models\Marketplace\MarketplaceAnnouncement;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.user')]

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.profile.dashboard');
    }
}
