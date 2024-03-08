<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands\Marketplace;

use App\Bots\pozorbottestbot\Commands\UserCommands\MenuCommand;
use App\Enums\Marketplace\Type as EnumType;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class Type extends Command
{
    public static $command = 'm_type';

    public static $usage = ['m_type'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $buttons = BotApi::inlineKeyboard([
            [
                array('Продать', TypeSave::$command, EnumType::sell->value),
                array('Купить', TypeSave::$command, EnumType::buy->value)
            ],
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
        ], 'type');

        $text = implode("\n", [
            "_Marketplace:_"."\n",
            "Какой *тип* объявления ты хочешь прислать?"
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
