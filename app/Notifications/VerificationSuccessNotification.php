<?php

namespace App\Notifications;

use App\Bots\pozorbottestbot\Commands\UserCommands\CreateAnnouncement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\Channels\TelegramChannel;
use Romanlazko\Telegram\Models\TelegramChat;

class VerificationSuccessNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
            ->line('Your email has been successfully verified.')
            ->action('Go to website', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toTelegram(TelegramChat $telegram_chat)
    {
        $text = implode("\n", [
            "Ваша почта была успешно подтверждена.",
        ]);

        $buttons = BotApi::inlineKeyboard([
            [array(CreateAnnouncement::getTitle('ru'), CreateAnnouncement::$command, '')],
        ]);

        return [
            'text'                      => $text,
            'chat_id'                   => $telegram_chat->chat_id,
            'reply_markup'              => $buttons,
            'parse_mode'                => 'HTML',
            'disable_web_page_preview'  => 'true',
            'parse_mode'                => 'Markdown',
        ];
    }
}
