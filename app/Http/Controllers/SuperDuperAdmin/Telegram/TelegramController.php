<?php
namespace App\Http\Controllers\SuperDuperAdmin\Telegram;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Romanlazko\Telegram\App\Config;
use Romanlazko\Telegram\App\Bot;
use Romanlazko\Telegram\Models\TelegramBot;

class TelegramController extends Controller
{
    public function index()
    {
        $telegram_bots = TelegramBot::all();

        return view('admin.telegram.index', compact(
            'telegram_bots'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(TelegramBot $telegram_bot)
    {
        $bot = new Bot($telegram_bot->token);

        $telegram_bot->photo                  = $bot->getBotChat()->getPhotoLink();
        $telegram_bot->webhook                = $bot::getWebhookInfo()->getResult();
        $telegram_bot->all_commands_list      = $bot->getAllCommandsList();
        $telegram_bot->config                 = Config::$config;
        $telegram_bot->logs                   = $telegram_bot->logs();

        return view('admin.telegram.show', compact([
            'telegram_bot'
        ]));
    }

    public function edit(TelegramBot $telegram_bot)
    {
        return view('admin.telegram.edit', compact([
            'telegram_bot'
        ]));
    }

    public function update(Request $request, TelegramBot $telegram_bot)
    {
        $bot = new Bot($request->token);

        $response = $bot::setWebHook([
            'url' => env('APP_URL').'/api/telegram/'.$bot->getBotId(),
        ]);

        $telegram_bot->update([
            'token' => $request->token,
            'settings' => $request->settings
        ]);

        return back()->with([
            'ok' => $response->getOk(),
            'description' => $response->getDescription(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TelegramBot $telegram_bot)
    {
        $telegram_bot->delete();

        return back();
    }
}
