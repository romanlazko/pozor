<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands\Marketplace;

use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class CountSave extends Command
{
    public static $command = 'm_count_save';

    public static $usage = ['m_count_save'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $this->getConversation()->update([
            'count' => $updates->getInlineData()->getCount()
        ]);

        return $this->bot->executeCommand(Photo::$command);
    }
}
