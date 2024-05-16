<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands;

use App\Models\User;
use App\Notifications\TelegramConnect;
use App\Notifications\TelegramEmailVerification;
use Illuminate\Support\Facades\Password;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\DB;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class SendEmailVerificationNotification extends Command
{
    public static $command = 'sendemailverificationnotification';

    public static $title = [
        'ru' => 'Отправить письмо снова',
        'en' => 'Send email again',
    ];

    public static $usage = ['sendemailverificationnotification'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $telegram_chat_id = DB::getChat($updates->getChat()->getId())->id;
        
        $user = User::where('telegram_chat_id', $telegram_chat_id)->first();

        if (!$user) {
            return $this->bot->executeCommand(MenuCommand::$command);
        }

        $token = Password::createToken($user);

        $user->notify(new TelegramEmailVerification($token, $telegram_chat_id));

        return BotApi::sendMessage([
            'chat_id' => $updates->getChat()->getId(),
            'text' => "На ваш эмейл было отправлено письмо для подтверждения. Пожалуйста, подтвердите свой эмейл, нажав на кнопку в письме.",
        ]);
    }
}