<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands\Marketplace;

use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class SaveCategory extends Command
{
    public static $command = 'save_category';

    public static $usage = ['save_category'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $this->getConversation()->update([
            'category_id' => $updates->getInlineData()->getCategoryId()
        ]);
            
        return $this->bot->executeCommand(Subcategory::$command);
    }
}
