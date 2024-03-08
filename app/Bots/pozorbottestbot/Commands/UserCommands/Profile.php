<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands;

use App\Models\User;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\DB;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class Profile extends Command
{
    public static $command = 'profile';

    public static $title = '';

    public static $usage = ['profile'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $user = User::where('telegram_chat_id', DB::getChat($updates->getChat()->getId()))->get();

        if ($user) {
            // return $this->bot->executeCommand(Profile::$command);
        }

        $notes = function ($key) {
            return $this->getConversation()->notes[$key] ?? null;
        };

        $buttons = BotApi::inlineKeyboard([
            [array("📧 Email: {$notes('email')}", Email::$command, '')],
            [array("☎️ Номер телефона: {$notes('phone')}", Phone::$command, '')],
            [
                array("👈 Назад", MenuCommand::$command, ''),
                array("Продолжить 👉", CreateUser::$command, ''),
            ]
        ]);

        return BotApi::returnInline([
            'text'          =>  "*Заполните пожалуйста данные своего профиля:*",
            'chat_id'       =>  $updates->getChat()->getId(),
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
        ]);
    }




}
