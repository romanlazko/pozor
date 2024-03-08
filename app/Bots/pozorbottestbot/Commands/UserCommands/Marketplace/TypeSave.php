<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands\Marketplace;

use App\Bots\pozorbottestbot\Commands\UserCommands\MenuCommand;
use App\Enums\Marketplace\Type as TypeEnum;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class TypeSave extends Command
{
    public static $command = 'm_type_save';

    public static $usage = ['m_type_save'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $type = $updates->getInlineData()->getType();

        $this->getConversation()->update([
            'type' => $type
        ]);

        if ($type == TypeEnum::sell->value) {
            return $this->bot->executeCommand(Count::$command);
        }

        if ($type == TypeEnum::buy->value) {
            return $this->bot->executeCommand(Photo::$command);
        }

        return $this->bot->executeCommand(MenuCommand::$command);
    }
}
