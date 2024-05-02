<?php

namespace App\Notifications;

use App\Channels\TelegramChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Romanlazko\Telegram\App\Bot;

class MessageSent extends Notification
{
    use Queueable;

    public $announcement;
    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($thread)
    {
        $this->announcement = $thread->announcement;
        $this->message = $thread->messages->last()->message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [TelegramChannel::class, 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toTelegram(object $notifiable)
    {
        $bot = new Bot('5981959980:AAHtBsJcUuXBfuR6FVgFfNh31r2jQwlF8io');

        $text = implode("\n", [
            "*You have a new message about the announcement:*"."\n",
            "{$this->announcement->title}"."\n",
            "{$this->message}"
        ]);

        $bot::sendMessage([
            'text'                      => $text,
            'chat_id'                   => $notifiable->chat_id,
            'parse_mode'                => 'HTML',
            'disable_web_page_preview'  => 'true',
            'parse_mode'                => 'Markdown',
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
