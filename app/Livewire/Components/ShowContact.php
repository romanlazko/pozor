<?php

namespace App\Livewire\Components;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Lukeraymonddowning\Honey\Traits\WithRecaptcha;

class ShowContact extends Component
{
    use WithRecaptcha;
    
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

    public function submit()
    {
        if (!$this->recaptchaPasses()) {
            return;
        }
        $this->phone = User::find($this->user_id)->phone;
    }
}
