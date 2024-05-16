<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands;

use App\Models\User;
use App\Notifications\TelegramEmailVerification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\DB;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class CreateUser extends Command
{
    public static $command = 'create_user';

    public static $title = '';

    public static $usage = ['create_user'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $notes = $this->getConversation()->notes;

        $user = User::where('email', $notes['email'])->first();

        if (! $user) {
            $user = User::create([
                'name' => $updates->getFrom()->getFirstName() . ' ' . $updates->getFrom()->getLastName(),
                'email' => $notes['email'],
                'phone' => $notes['phone'],
            ]);
        }

        $telegram_chat_id = DB::getChat($updates->getChat()->getId())->id;

        $token = Password::createToken($user);

        $user->notify(new TelegramEmailVerification($token, $telegram_chat_id));

        return BotApi::sendMessage([
            'chat_id' => $updates->getChat()->getId(),
            'text' => "На ваш эмейл было отправлено письмо для подтверждения. Пожалуйста, подтвердите свой эмейл, нажав на кнопку в письме.",
        ]);
    }
}
