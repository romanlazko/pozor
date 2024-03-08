<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands\Marketplace;

use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class CitySave extends Command
{
    public static $command = 'm_city_save';

    public static $title = [
        'ru' => 'Создать объявление',
        'en' => 'Create announcement',
    ];

    public static $usage = ['m_city_save'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $this->getConversation()->update([
            'city' => $updates->getInlineData()->getCity()
        ]);

        return $this->bot->executeCommand(Type::$command);
    }
}
