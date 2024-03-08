<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands\Marketplace;

use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class AwaitTitle extends Command
{
    public static $expectation = 'await_title';

    public static $pattern = '/^await_title$/';

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $text = $updates->getMessage()?->getText();

        if ($text === null) {
            $this->handleError("*Пришлите пожалуйста заголовок в виде текста.*");
            return $this->bot->executeCommand(Title::$command);
        }

        if (iconv_strlen($text) > 31){
            $this->handleError("*Слишком много символов*");
            return $this->bot->executeCommand(Title::$command);
        }

        $this->getConversation()->update([
            'title' => $text
        ]);
        
        return $this->bot->executeCommand(Price::$command);
    }
}
