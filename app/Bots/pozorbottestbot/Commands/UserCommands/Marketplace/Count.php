<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands\Marketplace;

use App\Bots\pozorbottestbot\Commands\UserCommands\MenuCommand;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class Count extends Command
{
    public static $command = 'm_count';

    public static $title = '';

    public static $usage = ['m_count'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {       
        $buttons = BotApi::inlineKeyboard([
            [
                array('Один', CountSave::$command, 'single'),
                array('Несколько', CountSave::$command, 'multiply')
            ],
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
        ], 'count');

        $data = [
            'text'          => "Сколько товаров будет в объявлении?",
            'reply_markup'  => $buttons,
            'chat_id'       => $updates->getChat()->getId(),
            'message_id'    => $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
            'parse_mode'    => "Markdown"
        ];
                
        return BotApi::returnInline($data);
    }
}
