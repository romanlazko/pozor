<?php

namespace App\Livewire\Admin\Telegram;

use App\Livewire\Admin\BaseAdminLayout;
use App\Models\TelegramBot;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Romanlazko\Telegram\Models\TelegramLog;
use Novadaemon\FilamentPrettyJson\PrettyJson;

class Logs extends BaseAdminLayout implements HasForms, HasTable
{
    public TelegramBot $telegram_bot;

    public function mount(TelegramBot $telegram_bot)
    {
        $this->telegram_bot = $telegram_bot;
    }
    public function table(Table $table): Table
    {
        return $table
            ->heading("Logs")
            ->defaultSort('created_at', 'desc')
            ->query(
                TelegramLog::where('telegram_bot_id', $this->telegram_bot->id))
            ->columns([
                TextColumn::make('created_at')
                    ->sortable()
                    ->dateTime(),
                TextColumn::make('message')
                    ->sortable()
                    ->grow()
                    ->lineClamp(2)
                    ->limit(50)
                    ->badge()
                    ->color('danger'),
                TextColumn::make('line')
            ])
            ->headerActions([
                Action::make('back')
                    ->icon('heroicon-o-arrow-left-circle')
                    ->url(route('admin.telegram.bot.index')),
            ])
            ->actions([
                ViewAction::make()
                    ->form([
                        Textarea::make('message')
                            ->rows(10),
                        PrettyJson::make('params'),
                        Textarea::make('file'),
                        TextInput::make('line'),
                        Textarea::make('trace')
                            ->rows(10),

                    ])
                    ->button()
                    ->color('warning'),
            ]);
    }
}
