<?php

namespace App\Livewire\Profile;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    #[Layout('layouts.user')]

    public function render()
    {
        return view('livewire.profile.create');
    }
}
