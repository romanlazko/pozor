<?php

namespace App\Livewire\Profile;

use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('layouts.user')]

class Edit extends Component
{
    public function render()
    {
        return view('livewire.profile.edit', [
            'user' => auth()->user()
        ]);
    }

    public function update()
    {
        
    }
}
