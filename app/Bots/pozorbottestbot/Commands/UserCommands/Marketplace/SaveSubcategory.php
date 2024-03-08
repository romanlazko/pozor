<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands\Marketplace;

use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class SaveSubcategory extends Command
{
    public static $command = 'save_subcategory';

    public static $usage = ['save_subcategory'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $this->getConversation()->update([
            'subcategory_id' => $updates->getInlineData()->getSubcategoryId()
        ]);
            
        return $this->bot->executeCommand(Condition::$command);
    }
}
