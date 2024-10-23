<?php

namespace App\Livewire\Pages\User\Profile;

use App\Enums\Status;
use App\Livewire\ActionWithCustomModal;
use App\Models\Announcement;
use App\Notifications\NewMessage;
use Filament\Actions\Action as ActionsAction;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action as ComponentsActionsAction;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;

class Messages extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    
    #[Layout('layouts.profile')]

    #[Title('Messages')]

    public function table(Table $table): Table
    {
        return $table
            ->view('components.livewire.tables.index')
            ->query(
                auth()->user()->threads()
                    ?->with(['announcement.media', 'announcement.features' => fn ($query) => $query->forAnnouncementCard(), 'users', 'latestMessage'])
                    ->withCount(['messages as uread_messages_count' => function ($query) {
                        $query->where('read_at', null)->where('user_id', '!=', auth()->id());
                    }])
                    ->getQuery()
            )
            ->paginated(false)
            ->columns([
                Split::make([
                    SpatieMediaLibraryImageColumn::make('announcement.media')
                        ->collection('announcements', 'thumb')
                        ->label(false)
                        ->grow(false)
                        ->circular()
                        ->extraAttributes(['class' => 'border rounded-full']),
                    TextColumn::make('user')
                        ->state(fn ($record) => "{$record->recipient->name} - {$record->announcement->title}")
                        ->description(fn ($record) => Str::limit($record->latestMessage->message, 30))
                        ->label(false)
                        ->lineClamp(2)
                        ->searchable()
                        ->grow()
                        ->weight(fn ($record) => $record->uread_messages_count > 0 ? FontWeight::Bold : FontWeight::Medium)
                        ->extraAttributes(['class' => 'text-xs w-full']),
                ])
            ])
            ->recordAction('answer')
            ->actions([
                Action::make('answer')
                    ->modalHeading(fn ($record) => new HtmlString(view('components.user-card', ['user' => $record->recipient])))
                    ->modalContent(function ($record) {
                        $record->messages()->where('user_id', '!=', auth()->id())->update(['read_at' => now()]);

                        return view('profile.message.show', ['messages' => $record->messages->load('user.media')]);
                    })
                    ->form([
                        Textarea::make('message')
                            ->required()
                            ->rows(1)
                            ->autosize()
                            ->placeholder('Message...')
                            ->hiddenLabel(),
                    ])
                    ->action(function ($data, $record, $form, $action) {
                        $record->messages()->create([
                            'user_id' => auth()->id(),
                            'message' => $data['message'],
                        ]);

                        // $record->recipient->notify((new NewMessage($record))->delay(now()->addMinutes(3)));

                        $this->dispatch('scroll-to-bottom');

                        $form->fill();

                        $action->halt();
                    })
                    ->modalCancelAction(false)
                    ->slideOver()
                    ->modalWidth('sm')
                    ->color('danger')
                    ->modalSubmitAction(fn ($action) => $action->color('primary'))
                    ->label(fn ($record) => $record->uread_messages_count)
                    ->badge(),
            ])
            ;
    }

    public function render()
    {
        return view('profile.message.index');
    }
}