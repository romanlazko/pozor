<?php
namespace App\Bots\inzerko_bot\Commands;

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
            UserCommands\StartCommand::class,
            UserCommands\DefaultCommand::class,
            UserCommands\HelpCommand::class,
            UserCommands\ReferalCommand::class,
            UserCommands\GetReferalCommand::class,
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
