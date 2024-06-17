<?php

namespace App\Livewire\Admin;

use App\Enums\Status;
use App\Models\Announcement;
use App\Jobs\SendAnnouncementToChannelJob;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Attributes\Layout;
use Livewire\Component;
use OwenIt\Auditing\Models\Audit;
use App\Models\TelegramChat;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\ActionSize;

use Filament\Forms\Components\Select;

class AnnouncementChannels extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    #[Layout('layouts.admin')]

    public Announcement $announcement;

    public function mount($announcement_id)
    {
        $this->announcement = Announcement::find($announcement_id);
    }

    public function render()
    {
        return view('livewire.admin.announcement-channels');
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
                    ->state(fn ($record) => $record->info['info'] ?? null)
            ])
            ->actions([
                ActionGroup::make([
                    DeleteAction::make('delete'),
                ])
                ->size(ActionSize::ExtraSmall)
                ->dropdownPlacement('right-start')
                ->button()
                ->hiddenLabel()
            ])
            ->headerActions([
                CreateAction::make()
                    ->form([
                        Select::make('telegram_chat_id')
                            ->label('Channel')
                            ->options(TelegramChat::where('type', 'channel')->get()->pluck('title', 'id')),
                    ])
                    ->action(function ($data) {
                        $this->announcement->channels()->updateOrCreate([
                            'telegram_chat_id' => $data['telegram_chat_id']
                        ]);
                    })
                    ->slideover(),
            ])
            ->poll('2s');
    }
}
