<?php

namespace App\Livewire\Profile\Announcements;

use App\Models\Marketplace\MarketplaceAnnouncement as MarketplaceAnnouncementModel;
use Livewire\Component;

class MarketplaceAnnouncement extends Component
{
    public $sold = null;
    public $new_price = null;

    public $announcement;

    public function render()
    {
        return view('livewire.profile.announcements.marketplace-announcement');
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
