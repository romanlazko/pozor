<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands\Marketplace;

use App\Bots\pozorbottestbot\Commands\UserCommands\MenuCommand;
use App\Enums\Marketplace\Condition as EnumCondition;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class Condition extends Command
{
    public static $command = 'condition';

    public static $title = '';

    public static $usage = ['condition'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        foreach (EnumCondition::cases() as $condition) {
            $conditionButtons[] = array($condition->trans('ru'), SaveCondition::$command, $condition->value);
        }
        $buttons = BotApi::inlineKeyboard([
            [...$conditionButtons],
            [
                array("👈 Назад", Category::$command, ''),
                array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')
            ]
        ], 'condition');

        $data = [
            'text'          => "В каком *состоянии* находится товар?",
            'chat_id'       => $updates->getChat()->getId(),
            'parse_mode'    => "Markdown",
            'message_id'    => $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
            'reply_markup'  => $buttons
        ];

        return BotApi::returnInline($data);
    }




}
