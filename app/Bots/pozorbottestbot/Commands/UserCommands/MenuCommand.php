<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands;

use App\Bots\pozorbottestbot\Commands\UserCommands\Marketplace\Marketplace;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class MenuCommand extends Command
{
    public static $command = '/menu';

    public static $title = [
        'ru' => '🏠 Главное меню',
        'en' => '🏠 Menu'
    ];

    public static $usage = ['/menu', 'menu', 'Главное меню', 'Menu'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $buttons = BotApi::inlineKeyboard([
            [array(Marketplace::getTitle('en'), Marketplace::$command, '')],
            // [array(RealEstate::getTitle('en'), RealEstate::$command, '')],
            // [array(Job::getTitle('en'), Job::$command, '')],
            // [array(Contacts::getTitle('en'), Contacts::$command, '')],
        ]);

        $text = implode("\n", [
            "Привет 👋" ."\n", 
            "Я помогу тебе создать объявление в каналах *Pozor*."."\n", 
            "_Выбери в каком типе каналов нужно опубликовать твое объявление!_",
        ]);

        $data = [
            'text'          =>  $text,
            'chat_id'       =>  $updates->getChat()->getId(),
            'reply_markup'  =>  $buttons,
            'parse_mode'    =>  'Markdown',
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()->getMessageId(),
        ];

        return BotApi::returnInline($data);
    }
}