<?php

namespace App\Livewire\Components;

use App\Models\User;
use Livewire\Component;
use Lukeraymonddowning\Honey\Traits\WithRecaptcha;

class ShowContact extends Component
{
    use WithRecaptcha;
    
    public $user_id;

    public $user;

    public $error;

    public function render()
    {
        return view('components.livewire.show-contact');
    }

    public function submit()
    {
        try {
            if ($this->recaptchaPasses()) {
                $this->user = User::where('id', $this->user_id)->select('phone', 'email', 'telegram_chat_id')->first();
            }
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
        }
    }
}
