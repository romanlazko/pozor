<?php
namespace App\Bots\pozorbottestbot\Commands;

use Romanlazko\Telegram\App\Commands\CommandsList as DefaultCommandsList;

class CommandsList extends DefaultCommandsList
{
    static protected $commands = [
        'admin'     => [
            AdminCommands\StartCommand::class,
            AdminCommands\DefaultCommand::class,
            AdminCommands\HelpCommand::class,
            AdminCommands\ReferalCommand::class,
            AdminCommands\GetReferalCommand::class,
        ],
        'user'      => [

            UserCommands\ConnectCommand::class,

            UserCommands\CreateAnnouncement::class,

            UserCommands\Email::class,
            UserCommands\AwaitEmail::class,

            UserCommands\Phone::class,
            UserCommands\AwaitPhone::class,

            UserCommands\CreateUser::class,
            UserCommands\SendEmailVerificationNotification::class,

            UserCommands\StartCommand::class,
            UserCommands\MenuCommand::class,
            
            // Marketplace
            
            // UserCommands\Marketplace\Marketplace::class,

            // UserCommands\Marketplace\City::class,
            // UserCommands\Marketplace\CitySave::class,

            // UserCommands\Marketplace\Type::class,
            // UserCommands\Marketplace\TypeSave::class,

            // UserCommands\Marketplace\Count::class,
            // UserCommands\Marketplace\CountSave::class,

            // UserCommands\Marketplace\Photo::class,
            // UserCommands\Marketplace\AwaitPhoto::class,

            // UserCommands\Marketplace\Title::class,
            // UserCommands\Marketplace\AwaitTitle::class,

            // UserCommands\Marketplace\Price::class,
            // UserCommands\Marketplace\AwaitPrice::class,

            // UserCommands\Marketplace\Condition::class,
            // UserCommands\Marketplace\SaveCondition::class,

            // UserCommands\Marketplace\Category::class,
            // UserCommands\Marketplace\SaveCategory::class,

            // UserCommands\Marketplace\Subcategory::class,
            // UserCommands\Marketplace\SaveSubcategory::class,

            // UserCommands\Marketplace\Caption::class,
            // UserCommands\Marketplace\AwaitCaption::class,

            // // UserCommands\Marketplace\ShowAnnouncement::class,
            // UserCommands\Marketplace\PublicAnnouncement::class,
            // UserCommands\Marketplace\SaveAnnouncement::class,
            // UserCommands\Marketplace\Published::class,
        ],
        'supergroup' => [
            DefaultCommands\EmptyResponseCommand::class,
        ],
        'default'   => [
            DefaultCommands\DefaultCommand::class,
            DefaultCommands\SendResultCommand::class,
            DefaultCommands\EmptyResponseCommand::class,
        ]
        
    ];

    static public function getCommandsList(?string $auth)
    {
        return array_merge(
            (self::$commands[$auth] ?? []), 
            (self::$default_commands[$auth] ?? [])
        ) 
        ?? self::getCommandsList('default');
    }

    static public function getAllCommandsList()
    {
        foreach (self::$commands as $auth => $commands) {
            $commands_list[$auth] = self::getCommandsList($auth);
        }
        return $commands_list;
    }
}
