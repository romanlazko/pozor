<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands;

use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class AwaitPhone extends Command
{
    public static $expectation = 'await_phone';

    public static $pattern = '/^await_phone$/';

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $text = $updates->getMessage()?->getText();

        if ($text === null) {
            $this->handleError("*Пришлите пожалуйста номер телефона в виде текста.*");
            return $this->bot->executeCommand(Phone::$command);
        }

        if (!preg_match('/^(\+?\d{3}\s*)?\d{3}[\s-]?\d{3}[\s-]?\d{3}$/', $text)) {
            $this->handleError("*Не верный формат номера телефона.*");
            return $this->bot->executeCommand(Phone::$command);
        }

        if (iconv_strlen($text) > 16){
            $this->handleError("*Слишком много символов*");
            return $this->bot->executeCommand(Phone::$command);
        }

        $this->getConversation()->update([
            'phone' => $text
        ]);
        
        return $this->bot->executeCommand(CreateUser::$command);
    }
}