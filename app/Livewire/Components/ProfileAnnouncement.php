<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ProfileAnnouncement extends Component
{
    public $sold = null;
    public $new_price = null;

    public $announcement;

    // public function mount($announcement)
    // {
    //     $this->announcement = $announcement->pluck('id', 'title')
    // }

    public function render()
    {
        return view('livewire.components.profile-announcement');
    }

    public function saveSold()
    {
        $this->announcement->sold(auth()->id());

        $this->reset('sold');
    }

    public function indicateAvailability()
    {
        $this->announcement->published(auth()->id());
    }

    public function delete()
    {
        $this->announcement->delete();
    }

    public function discount()
    {
        $this->announcement->discount($this->new_price);
        
        $this->reset('new_price');
    }
}
