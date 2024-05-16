<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\DB;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class CreateAnnouncement extends Command
{
    public static $command = 'create_announcement';

    public static $title = [
        'en' => 'Create Announcement',
        'ru' => 'Создать объявление',
    ];

    public static $usage = ['create_announcement'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $telegram_chat = DB::getChat($updates->getChat()->getId());

        $user = User::where('telegram_chat_id', $telegram_chat->id)->first();

        $url = URL::temporarySignedRoute('announcement.telegram-create', now()->addMinutes(10), ['email' => $user->email, 'telegram_chat_id' => $telegram_chat->id]);

        if (! $user) {
            return $this->bot->executeCommand(Email::$command);
        }

        if (! $user->hasVerifiedEmail()) {
            $buttons = BotApi::inlineKeyboard([
                [array(SendEmailVerificationNotification::getTitle('ru'), SendEmailVerificationNotification::$command, '')],
                [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
            ]);
    
            $data = [
                'text'          => "Вы не подтвердили свою почту. Пожалуйста, подтвердите свою почту, перейдя по ссылке на эмейле.",
                'chat_id'       => $updates->getChat()->getId(),
                'parse_mode'    => "Markdown",
                'reply_markup'  => $buttons,
                'message_id'    =>  $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
            ];
    
            return BotApi::returnInline($data);
        }

        $buttons = BotApi::inlineKeyboardWithLink(
            array('text' => "Опубликовать объявление", 'web_app' => ['url' => $url]),
            [
                [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')],
            ],
        );

        return BotApi::returnInline([
            'text'          => "Правила публикации: $url",
            'chat_id'       => $updates->getChat()->getId(),
            'parse_mode'    => "Markdown",
            'reply_markup'  => $buttons,
            'message_id'    => $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
        ]);
    }
}
