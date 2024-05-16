<?php

namespace App\Notifications;


use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class TelegramEmailVerification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $token, public $telegram_chat_id)
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
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return $this->buildMailMessage($this->resetUrl($notifiable));
    }

    /**
     * Get the mail representation of the notification.
     */
    public function buildMailMessage($url): MailMessage
    {
        return (new MailMessage)
            ->subject(Lang::get('Verify Email Account'))
            ->line(Lang::get('Please click the button below to verify your email.'))
            ->action(Lang::get('Verify Email'), $url)
            ->line(Lang::get('If you did not create an account, no further action is required.'));
    }

    protected function resetUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'telegram.email-verification',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'email' => $notifiable->getEmailForVerification(),
                'telegram_chat_id' => $this->telegram_chat_id,
                'token' => $this->token,
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]);
        // return url(route('telegram.email-verification', [
        //     'telegram_chat_id' => $this->telegram_chat_id,
        //     'token' => $this->token,
        //     'email' => $notifiable->getEmailForVerification(),
        // ], false));
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
