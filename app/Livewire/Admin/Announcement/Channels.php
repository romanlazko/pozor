<?php

namespace App\Livewire\Admin\Announcement;

use App\Livewire\Admin\BaseAdminLayout;
use App\Models\Announcement;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use App\Models\TelegramChat;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;

use Filament\Forms\Components\Select;

class Channels extends BaseAdminLayout implements HasForms, HasTable
{
    public Announcement $announcement;

    public function mount($announcement_id)
    {
        $this->announcement = Announcement::find($announcement_id);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading("All channels")
            ->query($this->announcement->channels()->with('channel')->getQuery())
            ->columns([
                TextColumn::make('channel.title')
                    ->sortable()
                    ->grow()
                    ->description(fn ($record) => $record->channel->username),
                TextColumn::make('status')
                    ->color(fn ($record) => $record->status->filamentColor())
                    ->badge(),
                TextColumn::make('info')
                    ->badge()
                    ->state(function ($record) {
                        $info = [];
                        foreach ($record->info ?? [] as $key => $value) {
                            $info[] = "{$key}: {$value}";
                        }
                        return $info;
                    })
            ])
            ->actions([
                DeleteAction::make('delete'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->form([
                        Select::make('telegram_chat_id')
                            ->label('Channel')
                            ->options(TelegramChat::where('type', 'channel')->whereNotIn('id', $this->announcement->channels()->pluck('telegram_chat_id')->toArray())->get()->pluck('title', 'id')),
                    ])
                    ->action(function ($data) {
                        $this->announcement->channels()->updateOrCreate([
                            'telegram_chat_id' => $data['telegram_chat_id']
                        ]);
                    })
                    ->extraModalWindowAttributes(['style' => 'background-color: #e5e7eb'])
                    ->slideover(),
            ])
            ->poll('2s');
    }
}
