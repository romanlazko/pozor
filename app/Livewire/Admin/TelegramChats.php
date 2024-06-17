<?php

namespace App\Livewire\Admin;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Geo;
use App\Models\TelegramBot;
use App\Models\TelegramChat;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Romanlazko\Telegram\App\Bot;
use Romanlazko\Telegram\Generators\BotDirectoryGenerator;
use Spatie\LaravelIgnition\Recorders\DumpRecorder\HtmlDumper;
use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\VarDumper\Dumper\HtmlDumper as DumperHtmlDumper;
use Symfony\Component\VarDumper\VarDumper;

class TelegramChats extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    
    #[Layout('layouts.admin')]

    public TelegramBot $telegram_bot;

    public function mount(TelegramBot $telegram_bot)
    {
        $this->telegram_bot = $telegram_bot;
    }
    
    public function render()
    {
        return view('livewire.admin.telegram-chats');
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading("All Chats")
            ->query(
                $this->telegram_bot
                    ->chats()
                    ->with(['latestMessage'])
                    ->getQuery())
            ->columns([
                TextColumn::make('name')
                    ->label('Чат')
                    ->searchable(['first_name', 'last_name', 'username', 'title'])
                    ->state(function (TelegramChat $telegram_chat) {
                        return "$telegram_chat->first_name $telegram_chat->last_name $telegram_chat->title";
                    })
                    ->description(fn (TelegramChat $telegram_chat) => $telegram_chat->username),
                TextColumn::make('type')
                    ->sortable()
                    ->badge(),
                TextColumn::make('role')
                    ->sortable()
                    ->badge(),
                TextColumn::make('latest_message')
                    ->label('Последнее сообщение')
                    ->state(fn (TelegramChat $telegram_chat) => $telegram_chat->latestMessage?->text)
                    ->limit(50)
                    ->wrap(),
                TextColumn::make('location')
                    ->state(fn (TelegramChat $telegram_chat) => $telegram_chat->geo?->name),
                TextColumn::make('updated_at')
                    ->sortable()
                    ->label('Последняя активность')
                    ->dateTime(),

            ])
            ->actions([
                ActionGroup::make([
                    DeleteAction::make(),
                    EditAction::make('Edit Location')
                        ->modalHeading(fn (TelegramChat $telegram_chat) => "Edit Location: {$telegram_chat->title}")
                        ->form([
                            Section::make()
                                ->schema([
                                    Select::make('country')
                                        ->label(__('Country'))
                                        ->options(Geo::select('name', 'country')->where('level', 'PCLI')->pluck('name', 'country'))
                                        ->searchable()
                                        ->afterStateUpdated(function (Set $set) {
                                            $set('geo_id', null);
                                        })
                                        ->placeholder(__('Country'))
                                        ->default('CZ')
                                        ->dehydrated(false)
                                        ->live(),
                                    Select::make('geo_id')
                                        ->label(__('City'))
                                        ->searchable()
                                        ->preload()
                                        ->options(fn (Get $get) => Geo::where('country', $get('country') ?? 'CZ')?->pluck('name', 'id'))
                                        ->getSearchResultsUsing(function (string $search, Get $get) {
                                            return Geo::where('country', $get('country') ?? 'CZ')
                                                ->whereRaw('LOWER(alternames) LIKE ?', ['%' . mb_strtolower($search) . '%'])
                                                ->pluck('name', 'id');
                                        })
                                        ->afterStateHydrated(fn (Set $set, TelegramChat $telegram_chat) => $set('country', $telegram_chat->geo?->country))
                                        ->live()
                                        ->placeholder(__('City'))
                                ])
                                ->columns(2)
                        ])
                        ->visible(fn (TelegramChat $telegram_chat) => $telegram_chat->type === 'channel')
                        ->slideOver()
                        ->closeModalByClickingAway(false),
                ])
            ]);
    }
}
