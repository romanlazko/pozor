<?php

namespace App\Livewire\Components;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ShowContact extends Component
{
    public $user_id;

    public $phone;

    public function render()
    {
        $user = User::find($this->user_id);

        if ($user?->phone) {
            return view('livewire.components.show-contact');
        }
        return view('livewire.components.empty');
    }

    public function showContacts()
    {
        $this->phone = User::find($this->user_id)->phone;
    }
}
