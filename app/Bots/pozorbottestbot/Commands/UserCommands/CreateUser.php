<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands;

use App\Models\User;
use App\Notifications\TelegramEmailVerification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
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
        $telegram_chat = DB::getChat($updates->getChat()->getId());

        $notes = $this->getConversation()->notes;

        $user = User::where('email', $notes['email'])->first();

        if (! $user) {
            $password = Str::random(8);

            $user = User::create([
                'name' => $updates->getFrom()->getFirstName() . ' ' . $updates->getFrom()->getLastName(),
                'email' => $notes['email'],
                'phone' => $notes['phone'],
                'password' => Hash::make($password),
            ]);

            $photo_url = BotApi::getPhoto(['file_id' => $telegram_chat->photo]);

            $user->addMediaFromUrl($photo_url)->toMediaCollection('avatar');
        }

        $token = Password::createToken($user);

        $user->notify(new TelegramEmailVerification($token, $telegram_chat->id));

        return BotApi::sendMessage([
            'chat_id' => $updates->getChat()->getId(),
            'text' => "$password На ваш эмейл было отправлено письмо для подтверждения. Пожалуйста, подтвердите свой эмейл, нажав на кнопку в письме.",
        ]);
    }
}
