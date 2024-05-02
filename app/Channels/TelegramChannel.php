<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class TelegramChannel 
{
    public function send(object $notifiable, Notification $notification): void
    {
        $message = $notification->toTelegram($notifiable);
 
        // Send notification to the $notifiable instance...
    }
}
