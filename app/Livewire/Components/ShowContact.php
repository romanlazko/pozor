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

    public $error;

    public function mount($user_id)
    {
        $this->user_id = $user_id;
    }

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
        try {
            if ($this->recaptchaPasses()) {
                $this->phone = User::find($this->user_id)->phone;
            }
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
        }
    }
}
