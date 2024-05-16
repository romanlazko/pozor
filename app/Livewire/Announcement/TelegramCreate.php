<?php

namespace App\Livewire\Announcement;

class TelegramCreate extends Create
{
    public function create(): void
    {
        $this->createAnnouncement((object) $this->data);

        dump('created');
    }
}