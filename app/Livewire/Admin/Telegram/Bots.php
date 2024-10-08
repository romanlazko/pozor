<?php

namespace App\Livewire\Admin\Telegram;

use App\Livewire\Admin\BaseAdminLayout;
use App\Models\Category;
use App\Models\TelegramBot;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Romanlazko\Telegram\App\Bot;
use Romanlazko\Telegram\Generators\BotDirectoryGenerator;

class Bots extends BaseAdminLayout implements HasForms, HasTable
{
    public function table(Table $table): Table
    {
        return $table
            ->heading("All bots")
            ->query(TelegramBot::query())
            ->columns([
                SpatieMediaLibraryImageColumn::make('avatar')
                    ->collection('bots')
                    ->conversion('thumb'),
                TextColumn::make('first_name')
                    ->sortable()
                    ->grow()
                    ->description(fn ($record) => $record->username),
            ])
            ->headerActions([
                CreateAction::make()
                    ->model(Category::class)
                    ->icon('heroicon-o-plus-circle')
                    ->form([
                        Section::make('Telegram')
                            ->schema([
                                TextInput::make('token')
                            ])
                    ])
                    ->action(function (array $data) {
                        $bot = new Bot($data['token']);

                        $response = $bot::setWebHook([
                            'url' => env('APP_URL').'/api/telegram/'.$bot->getBotId(),
                        ]);

                        if ($response->getOk()) {
                            $telegram_bot = TelegramBot::updateOrCreate([
                                'id'            => $bot->getBotChat()->getId(),
                                'first_name'    => $bot->getBotChat()->getFirstName(),
                                'last_name'     => $bot->getBotChat()->getLastName(),
                                'username'      => $bot->getBotChat()->getUsername(),
                                'token'         => $data['token'],
                            ]);

                            $telegram_bot->addMediaFromUrl($bot->getBotChat()->getPhotoLink())->toMediaCollection('bots');
                        }

                        if ($telegram_bot) {
                            BotDirectoryGenerator::createBotDirectories($telegram_bot->username);
                        }

                        return $response->getDescription();
                    })  
                    ->slideOver()
                    ->closeModalByClickingAway(false),
            ])
            ->actions([
                Action::make('Chats')
                    ->button()
                    ->icon('heroicon-o-chat-bubble-bottom-center')
                    ->url(fn ($record) => route('admin.telegram.bot.chat.index', $record))
                    ->color('success'),

                Action::make('Logs')
                    ->button()
                    ->icon('heroicon-o-clipboard-document-list')
                    ->url(fn ($record) => route('admin.telegram.bot.logs.index', $record))
                    ->color('warning')
            ]);
    }
}
