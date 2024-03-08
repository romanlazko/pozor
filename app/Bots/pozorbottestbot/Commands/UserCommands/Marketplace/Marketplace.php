<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands\Marketplace;

use App\Bots\pozorbottestbot\Commands\UserCommands\MenuCommand;
use App\Bots\pozorbottestbot\Commands\UserCommands\Profile;
use App\Models\User;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\DB;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class Marketplace extends Command
{
    public static $command = 'marketplace';

    public static $title = 'Marketplace';

    public static $usage = ['marketplace'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $user = User::where('telegram_chat_id', DB::getChat($updates->getChat()->getId())->id)->first();

        if (!$user) {
            return $this->bot->executeCommand(Profile::$command);
        }

        $buttons = BotApi::inlineKeyboard([
            [array('Да, все понятно', City::$command, '')],
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
        ]);

        $text = implode("\n", [
            "*Отлично, ты выбрал(а) Marketplace!*"."\n",
            "Обязательно ознакомься с правилами публикации по [ссылке](https://telegra.ph/Pravila-pablika-Baraholka-03-21)!"."\n",
            "Я по шагово буду присылать вопросы, отвечай пожалуйста, на них четко и честно!"."\n",
            "*Все понятно?*"
        ]);

        $data = [
            'text'          => $text,
            'reply_markup'  => $buttons,
            'chat_id'       => $updates->getChat()->getId(),
            'message_id'    => $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
            'parse_mode'    => "Markdown"
        ];
                
        return BotApi::returnInline($data);
        
    }
}
