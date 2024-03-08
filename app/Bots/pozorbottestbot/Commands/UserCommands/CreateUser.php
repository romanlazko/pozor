<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
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

        $user = User::where('telegram_chat_id', DB::getChat($updates->getChat()->getId())->id)->first();

        if (!$user) {
            $user = User::create([
                'name' => $updates->getFrom()->getFirstName(),
                'telegram_chat_id' => DB::getChat($updates->getChat()->getId())->id,
                'email' => $notes['email'],
                'phone' => $notes['phone'],
                'password' => Hash::make(''),
            ]);
    
            event(new Registered($user));
        }

        return $this->bot->executeCommand(MenuCommand::$command);
    }
}
