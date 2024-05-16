<?php

namespace App\Livewire\Announcement;

class TelegramCreate extends Create
{
    public function create(): void
    {
        $this->validate();

        $this->createAnnouncement((object) $this->data);

        $this->redirectRoute('created');
    }
}