<?php

namespace App\Livewire\Pages\User\Announcement;

class TelegramCreate extends Create
{
    public function create(): void
    {
        $this->validate();

        $this->createAnnouncement((object) $this->data);

        $this->dispatch('announcement-created');
    }
}