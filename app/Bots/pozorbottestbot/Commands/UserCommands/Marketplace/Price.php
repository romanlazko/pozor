<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands\Marketplace;

use App\Bots\pozorbottestbot\Commands\UserCommands\MenuCommand;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class Price extends Command
{
    public static $command = 'cost';

    public static $title = '';

    public static $usage = ['cost'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $updates->getFrom()->setExpectation(AwaitPrice::$expectation);
        
        $buttons = BotApi::inlineKeyboard([
            [
                array("👈 Назад", Title::$command, ''),
                array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')
            ]
        ]);

        $data = [
            'text'          => "Укажи в кронах *стоимость* товара."."\n\n"."_Максимально_ *12* _символов_.",
            'chat_id'       => $updates->getChat()->getId(),
            'parse_mode'    => "Markdown",
            'reply_markup'  => $buttons,
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
        ];

        return BotApi::returnInline($data);
    }




}
