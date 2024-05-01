<?php

namespace App\Livewire\Components;

use App\Jobs\SendMessageJob;
use App\Models\Announcement;
use Livewire\Component;

class SendMessage extends Component
{
    public Announcement $announcement; 
    public $message;

    public function render()
    {
        return view('livewire.components.send-message');
    }

    public function sendMessage()
    {
        SendMessageJob::dispatch($this->announcement, $this->message);

        $this->reset('message');
    }
}
