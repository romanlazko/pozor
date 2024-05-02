<?php

namespace App\Livewire\Profile;

use App\Enums\Status;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;

class Announcements extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    
    #[Layout('layouts.profile')]

    #[Title('Announcements')]
    
    public function table(Table $table): Table
    {
        return $table
            ->query(auth()->user()->announcements()->getQuery())
            ->columns([
                
                Stack::make([
                    TextColumn::make('status')
                        ->label('Status')
                        ->getStateUsing(fn ($record) => $record->status->name)
                        ->color(fn ($record) => $record->status->filamentColor())
                        ->extraAttributes(['class' => 'py-1'])
                        ->badge(),
                    ImageColumn::make('attachments')
                        ->defaultImageUrl(fn ($record) => $record->getFirstMedia('announcements')?->getUrl())
                        ->extraImgAttributes(['class' => 'rounded-xl border-2 border-white hover:border-indigo-600'])
                        ->height(200)
                        ->url(fn ($record) => route('announcement.show', $record))
                        ->extraAttributes(['class' => 'py-2']),
                    TextColumn::make('title')
                        ->description(fn ($record) => $record->current_price . ' ' . $record->currency->name)
                        ->wrap()
                        ->extraAttributes(['class' => 'py-2'])
                        ->weight(FontWeight::Bold),
                    TextColumn::make('description')
                        ->limit(100)
                        ->wrap(),

                ])
                ->hiddenFrom('sm'),

                Split::make([
                    ImageColumn::make('attachments')
                        ->defaultImageUrl(fn ($record) => $record->getFirstMedia('announcements')?->getUrl())
                        ->extraImgAttributes(['class' => 'rounded-xl border-2 border-white hover:border-indigo-600 w-12'])
                        ->height(50)
                        ->circular()
                        ->url(fn ($record) => route('announcement.show', $record))
                        ->extraAttributes(['class' => 'my-auto'])
                        ->grow(false),
                    TextColumn::make('title')
                        ->description(fn ($record) => Str::limit($record->description, 50))
                        ->weight(FontWeight::Bold),
                    TextColumn::make('price')
                        ->getStateUsing(fn ($record) => $record->current_price . ' ' . $record->currency->name)
                        ->wrap(),
                    TextColumn::make('status')
                        ->label('Status')
                        ->getStateUsing(fn ($record) => $record->status->name)
                        ->color(fn ($record) => $record->status->filamentColor())
                        ->badge(),
                ])
                ->visibleFrom('sm')
                ->from('md')
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('sold')
                        ->label('Mark as "Sold"')
                        ->form([
                            Section::make()
                                ->schema([
                                    ToggleButtons::make('sold')
                                        ->label(__('Where did you sell it?'))
                                        ->options([
                                            '1' => 'I sold it on this site',
                                            '2' => 'I sold it on another site',
                                            '3' => 'I do not want to answer',
                                        ])
                                        ->required()
                                ])
                        ])
                        ->slideOver()
                        ->modalWidth('sm')
                        ->closeModalByClickingAway(false)
                        ->icon('heroicon-m-archive-box-x-mark')
                        ->color('success')
                        ->action(function ($record, array $data) {
                            $record->sold();
                        })
                        ->visible(fn ($record) => $record->status == Status::published),
                    Action::make('available')
                        ->label('Mark as "Available"')
                        ->icon('heroicon-m-archive-box-arrow-down')
                        ->color('info')
                        ->action(function ($record) {
                            $record->published();
                        })
                        ->visible(fn ($record) => $record->status == Status::sold),
                    EditAction::make()
                        ->form([
                            Grid::make(2)
                                ->schema([
                                    SpatieMediaLibraryFileUpload::make('attachments')
                                        ->collection('announcements')
                                        ->hiddenLabel()
                                        ->multiple()
                                        ->columnSpan(1),
                                    Section::make()
                                        ->schema([
                                            TextInput::make('title')
                                                ->label('Title')
                                                ->required(),
                                            Textarea::make('description')
                                                ->label('Description')
                                                ->autosize()
                                                ->rows(6)
                                                ->required(),
                                        ])
                                        ->columnSpan(1)
                                ])
                            
                        ])
                        ->modalDescription('Are you sure you\'d like to edit this post? We\'ll have to moderate it again.')
                        ->after(fn ($record) => $record->moderate())
                        ->slideOver()
                        ->closeModalByClickingAway(false)
                        ->visible(fn ($record) => $record->status != Status::sold),
                    DeleteAction::make()
                ])
                ->button()
            ]);
    }
    public function render()
    {
        return view('livewire.profile.announcement')->title('My Announcements');
    }
}
