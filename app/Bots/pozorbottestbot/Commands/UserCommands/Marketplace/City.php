<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands\Marketplace;

use App\Bots\pozorbottestbot\Commands\UserCommands\MenuCommand;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class City extends Command
{
    public static $command = 'm_city';

    public static $title = [
        'ru' => 'Создать объявление',
        'en' => 'Create announcement',
    ];

    public static $usage = ['m_city'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $this->getConversation()->clear();

        $this->updates->getInlineData()->unset();

        $buttons = BotApi::inlineKeyboard([
            [
                array('Прага', CitySave::$command, 'prague'),
                array('Брно', CitySave::$command, 'brno'),
            ],
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
        ], 'city');
                                
        return BotApi::editMessageText([
            'text'          => "В каком *городе* ты хочешь опубликовать объявление?",
            'reply_markup'  => $buttons,
            'chat_id'       => $updates->getChat()->getId(),
            'message_id'    => $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
            'parse_mode'    => "Markdown"
        ]);
    }
}
