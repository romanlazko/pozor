<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands\Marketplace;

use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class AwaitPrice extends Command
{
    public static $expectation = 'await_price';

    public static $pattern = '/^await_price$/';

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $text = $updates->getMessage()?->getText();

        if ($text === null) {
            $this->handleError("*Пришлите пожалуйста стоимость в виде текстового сообщения.*");
            return $this->bot->executeCommand(Price::$command);
        }

        if (iconv_strlen($text) > 12){
            $this->handleError("*Слишком много символов*");
            return $this->bot->executeCommand(Price::$command);
        }

        if (!is_numeric($text)){
            $this->handleError("*Стоимость должна быть указана только цифрами*");
            return $this->bot->executeCommand(Price::$command);
        }

        $this->getConversation()->update([
            'price' => $text,
        ]);

        return $this->bot->executeCommand(Category::$command);
    }
}
