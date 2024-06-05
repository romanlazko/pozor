<?php

namespace App\Livewire\Components;

use App\Models\User;
use Livewire\Component;
use Lukeraymonddowning\Honey\Traits\WithRecaptcha;

class ShowContact extends Component
{
    use WithRecaptcha;
    
    public $user_id;

    public $contacts;

    public $error;

    public function render()
    {
        $user = User::where('id', $this->user_id)->with('media')->first();

        if ($user?->isProfileFilled()) {
            return view('components.livewire.show-contact', compact('user'));
        }
        return view('components.livewire.empty');
    }

    public function submit()
    {
        try {
            if ($this->recaptchaPasses()) {
                $this->contacts = User::find($this->user_id)->phone;
            }
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
        }
    }
}
