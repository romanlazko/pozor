<?php

namespace App\Livewire\Components\Announcement;

class TelegramCreate extends Create
{
    public function create(): void
    {
        $this->validate();

        $this->createAnnouncement((object) $this->data);

        $this->dispatch('announcement-created');
    }
}