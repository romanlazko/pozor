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
use Illuminate\Support\Facades\Password;

class TelegramEmailVerification extends Notification implements ShouldQueue
{
    use Queueable;

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
        $token = Password::createToken($notifiable);

        $url = URL::temporarySignedRoute(
            'telegram.email-verification',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'email' => $notifiable->getEmailForVerification(),
                'telegram_chat_id' => $notifiable->telegram_chat_id,
                'telegram_token' => $notifiable->telegram_token,
                'token' => $token,
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]);

        return (new MailMessage)
            ->subject(Lang::get('Verify Email Account'))
            ->line(Lang::get('Please click the button below to verify your email.'))
            ->action(Lang::get('Verify Email'), $url)
            ->line(Lang::get('If you did not create an account, no further action is required.'));
    }
}
