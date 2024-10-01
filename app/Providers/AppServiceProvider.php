<?php

namespace App\Providers;

use App\Services\Translators\NlpTranslation;
use DeepL\Translator;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Romanlazko\Telegram\App\Bot;
use Romanlazko\Telegram\Models\TelegramBot;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('rapid-api-translator', function () {
            return new NlpTranslation(env('RAPID_API_KEY'));
        });

        $this->app->bind('bot', function () {
            return new Bot(env('TELEGRAM_BOT_TOKEN', TelegramBot::first()->token));
        });

        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->bind('htmlpurifier', function ($app) {
            $config = HTMLPurifier_Config::createDefault();
            return new HTMLPurifier($config);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentColor::register([
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::Blue,
            'primary' => Color::Indigo,
            'success' => Color::Green,
            'warning' => Color::Amber,
            'neutral' => Color::Neutral,
            'white' => Color::hex('#ffffff'),
        ]);
    }
}
