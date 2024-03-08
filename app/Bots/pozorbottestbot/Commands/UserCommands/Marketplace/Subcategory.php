<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands\Marketplace;

use App\Bots\pozorbottestbot\Commands\UserCommands\MenuCommand;
use App\Models\Marketplace\MarketplaceSubcategory;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class Subcategory extends Command
{
    public static $command = 'subcategory';

    public static $title = '';

    public static $usage = ['subcategory'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $notes = $this->getConversation()->notes;

        $buttons = MarketplaceSubcategory::where('is_active', true)->where('marketplace_category_id', $notes['category_id'])
            ->get()
            ->map(function ($subcategory) {
                return array($subcategory->name, SaveSubcategory::$command, $subcategory->id);
            })
            ->chunk(3)
            ->toArray();

        if (empty($buttons)) {
            return $this->bot->executeCommand(Condition::$command);
        }

        $buttons = BotApi::inlineKeyboard([
            ...$buttons,
            [
                array("👈 Назад", Category::$command, ''),
                array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')
            ],
        ], 'subcategory_id');

        $data = [
            'text'          => "Выбери к какой *под категории* относится товар(ы).",
            'chat_id'       => $updates->getChat()->getId(),
            'message_id'    => $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
            'parse_mode'    => "Markdown",
            'reply_markup'  => $buttons
        ];

        return BotApi::returnInline($data);
    }
}
