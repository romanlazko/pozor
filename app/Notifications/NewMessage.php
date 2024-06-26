<?php

namespace App\Notifications;

use App\Facades\Bot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\Channels\TelegramChannel;

class NewMessage extends Notification implements ShouldQueue
{
    use Queueable;

    public $announcement;
    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $thread)
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
        return ['mail', TelegramChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line("🆕You have a new message about the announcement🆕")
                    ->line("**{$this->announcement->title}**")
                    ->line($this->message)
                    ->action('View', route('profile.message.show', $this->thread->id))
                    ->line('Thank you for using our application!');
    }

    public function toTelegram(object $notifiable)
    {
        $text = implode("\n", [
            "🆕You have a new message about the announcement:🆕"."\n",
            "*{$this->announcement->title}*"."\n",
            "{$this->message}"."\n",
            "[Go to chat](" . route('profile.message.show', $this->thread->id). ")"
        ]);

        return [
            'text'                      => $text,
            'chat_id'                   => $notifiable->chat->chat_id,
            'parse_mode'                => 'HTML',
            'disable_web_page_preview'  => 'true',
            'parse_mode'                => 'Markdown',
        ];
    }

    public function shouldSend(object $notifiable): bool
    {
        $unreadMessagesCount = $this->thread->messages()
            ->where('read_at', null)
            ->where('user_id', '!=', $notifiable->id)
            ->count();

        return $unreadMessagesCount > 0;
    }
}
