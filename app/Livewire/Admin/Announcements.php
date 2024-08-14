<?php

namespace App\Livewire\Admin;

use App\Enums\Status;
use App\Livewire\Components\Tables\Columns\ImageGridColumn;
use App\Models\Announcement;
use App\Models\Category;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use Filament\Forms\Components\Livewire;
use App\Livewire\Components\Tables\Columns\StatusSwitcher;
use Filament\Forms\Components\Select;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Announcements extends BaseAdminLayout implements HasForms, HasTable
{
    public function table(Table $table): Table
    {
        return $table
            ->heading("All announcements")
            ->headerActions([
                Action::make('Generate fake announcements')
                    ->form([
                        Select::make('count')
                            ->options([
                                10 => 10,
                                30 => 30,
                                100 => 100,
                            ])
                            ->label('Count of announcements')
                            ->default(100)
                    ])
                    ->action(function (array $data) {
                        $buses = intdiv($data['count'], 10);

                        for ($i = 0; $i < $buses; $i++) {
                            Announcement::factory(10)->create();
                        }
                    }),
            ])
            ->query(Announcement::with([
                'media', 
                'user.media', 
                'categories', 
                'channels.channel', 
                'geo', 
                'features' => fn ($query) => $query->whereHas('attribute', fn ($query) => $query->whereHas('showSection', fn ($query) => $query->whereIn('slug', ['title']))), 
                'currentStatus'
            ]))
            ->columns([
                Stack::make([
                    StatusSwitcher::make('currentStatus.status')
                        ->options(Status::class)
                        ->color(fn (Announcement $announcement) => $announcement->currentStatus->status->filamentColor()),

                    TextColumn::make('categories')
                        ->getStateUsing(fn (Announcement $announcement) => $announcement->categories->pluck('name'))
                        ->badge(),
                    
                    Panel::make([
                        Split::make([
                            SpatieMediaLibraryImageColumn::make('user.avatar')
                                ->collection('avatar', 'thumb')
                                ->grow(false)
                                ->circular()
                                ->extraAttributes(['class' => 'border rounded-full']),
                            TextColumn::make('user.name')
                                ->description(fn (Announcement $announcement) => $announcement->user?->email)
                                ->extraAttributes(['class' => 'text-xs'])
                        ])
                    ]),
                    
                    ImageGridColumn::make('image')
                        ->collection('announcements')
                        ->height(200)
                        ->extraAttributes(['class' => 'w-full']),
                    
                    TextColumn::make('Title')
                        ->wrap()
                        ->weight(FontWeight::Bold)
                        ->state(fn (Announcement $announcement) => $announcement->getFeatureByName('title')?->value)
                        ->description(fn (Announcement $announcement) => 
                            new HtmlString(
                                app(MarkdownRenderer::class)->toHtml($announcement->getFeatureByName('description')?->value ?? '')
                            )
                        )
                        ->extraAttributes([
                            'class' => 'html text-xs'
                        ]),

                    TextColumn::make('location')
                        ->state(fn (Announcement $announcement) => $announcement->geo->name)
                        ->badge()
                        ->color('gray'),

                    TextColumn::make('channels')
                        ->state(fn (Announcement $announcement): View => view(
                            'components.livewire.tables.columns.telegram-channel-status',
                            [
                                'channels' => $announcement->channels
                            ],
                        ))
                        ->action(
                            Action::make("Telegram Channels")
                                ->modalHeading(fn (Announcement $announcement) => "Telegram Channels: {$announcement->getFeatureByName('title')?->value}")
                                ->form(fn (Announcement $announcement) => [
                                    Livewire::make(AnnouncementChannels::class, ['announcement_id' => $announcement->id]),
                                ])
                                ->icon('heroicon-o-chat-bubble-bottom-center-text')
                                ->slideover(),
                        )
                        ->grow(false),
                ])
                ->extraAttributes(['class' => 'space-y-2'])
            ])
            
            ->actions([
                    // CREATE STATUS
                    ActionGroup::make([
                        Action::make('send_to_moderation')
                            ->label(__("Send to moderation"))
                            ->action(fn (Announcement $announcement) => $announcement->moderate())
                            ->color('info')
                            ->button()
                            ->icon('heroicon-m-arrow-right-circle')
                            ->size(ActionSize::ExtraSmall),
                    ])
                    ->dropdown(false)
                    ->visible(fn (Announcement $announcement) => 
                        $announcement->status?->isCreated()
                    ),

                    // MODERATION STATUS
                    ActionGroup::make([
                        Action::make('approve')
                            ->label(__("Approve"))
                            ->action(fn (Announcement $announcement) => $announcement->approve())
                            ->color('info')
                            ->button()
                            ->icon('heroicon-s-check-circle')
                            ->size(ActionSize::ExtraSmall),

                        Action::make('reject')
                            ->label(__("Reject"))
                            ->form([
                                Section::make()
                                    ->schema([
                                        Textarea::make('info')
                                            ->label(__("Reason"))
                                            ->required()
                                            ->rows(6),
                                    ])
                            ])
                            ->action(fn (array $data, Announcement $announcement) => $announcement->reject($data))
                            ->color('danger')
                            ->button()
                            ->icon('heroicon-c-no-symbol')
                            ->slideOver()
                            ->modalWidth('md')
                            ->size(ActionSize::ExtraSmall),
                    ])
                    ->dropdown(false)
                    ->visible(fn (Announcement $announcement) => 
                        $announcement->status?->isOnModeration()
                    ),

                    // TRANSLATE STATUS
                    ActionGroup::make([
                        Action::make('translate')
                            ->label(__("Translate"))
                            ->action(fn (Announcement $announcement) => $announcement->translate())
                            ->color('info')
                            ->button()
                            ->icon('heroicon-c-language')
                            ->size(ActionSize::ExtraSmall)
                            ->visible(fn (Announcement $announcement) => $announcement->status?->isApproved()),
                            
                        Action::make('publish_without_translating')
                            ->label(__("Publish without translating"))
                            ->action(fn (Announcement $announcement) => $announcement->publish())
                            ->color('warning')
                            ->button()
                            ->icon('heroicon-c-no-symbol')
                            ->size(ActionSize::ExtraSmall),

                        Action::make('stop_translating')
                            ->label(__("Stop"))
                            ->action(fn (Announcement $announcement) => $announcement->translationFailed())
                            ->color('danger')
                            ->button()
                            ->icon('heroicon-c-no-symbol')
                            ->size(ActionSize::ExtraSmall)
                            ->visible(fn (Announcement $announcement) => $announcement->status?->isAwaitTranslation()),
                        
                        Action::make('retry_translation')
                            ->label(__("Retry"))
                            ->action(fn (Announcement $announcement) => $announcement->translate())
                            ->color('warning')
                            ->button()
                            ->icon('heroicon-c-arrow-path-rounded-square')
                            ->size(ActionSize::ExtraSmall)
                            ->visible(fn (Announcement $announcement) => $announcement->status?->isTranslationFailed()),
                    ])
                    ->dropdown(false)
                    ->visible(fn (Announcement $announcement) => 
                        $announcement->status?->isApproved() OR $announcement->status?->isAwaitTranslation() OR $announcement->status?->isTranslationFailed()
                    ),

                    // PUBLICATION STATUS
                    ActionGroup::make([
                        Action::make('stop_publishing')
                            ->label(__("Stop"))
                            ->action(fn (Announcement $announcement) => $announcement->publishingFailed())
                            ->color('danger')
                            ->button()
                            ->icon('heroicon-c-no-symbol')
                            ->size(ActionSize::ExtraSmall)
                            ->visible(fn (Announcement $announcement) => 
                                $announcement->status?->isAwaitPublication()
                            ),

                        Action::make('retry_publication')
                            ->label(__("Retry"))
                            ->action(fn (Announcement $announcement) => $announcement->publish())
                            ->color('warning')
                            ->button()
                            ->icon('heroicon-c-arrow-path-rounded-square')
                            ->size(ActionSize::ExtraSmall)
                            ->visible(fn (Announcement $announcement) => 
                                $announcement->status?->isPublishingFailed()
                            ),
                    ])
                    ->dropdown(false),

                    ActionGroup::make([
                        Action::make('history')
                            ->label(__("View history"))
                            ->form(fn (Announcement $announcement) => [
                                Livewire::make(AnnouncementAudits::class, ['announcement_id' => $announcement->id])
                            ])
                            ->modalSubmitAction(false)
                            ->slideover()
                            ->icon('heroicon-o-clock'),

                        DeleteAction::make(),
                    ])
                    ->size(ActionSize::ExtraSmall)
                    ->dropdownPlacement('right-start')
                    ->button()
                    ->hiddenLabel()
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(function () {
                        return DB::table('announcement_statuses as asm')
                            ->select('asm.status', DB::raw('count(announcements.id) as count'))
                            ->join('announcements', function($join) {
                                $join->on('announcements.id', '=', 'asm.announcement_id')
                                    ->where('asm.id', function($query) {
                                        $query->select(DB::raw('max(id)'))
                                            ->from('announcement_statuses as sub_asm')
                                            ->whereColumn('sub_asm.announcement_id', 'asm.announcement_id');
                                    })
                                    ->where('deleted_at', null);
                            })
                            ->groupBy('asm.status')
                            ->get()
                            ->mapWithKeys(function ($status) {
                                return [$status->status => Status::from($status->status)->getLabel() . ' (' . $status->count . ')'];
                            })
                            ->toArray();
                    })
                    ->query(fn ($query, $data) =>
                        $query->whereHas('currentStatus', fn ($query) => $query->when($data['value'], fn ($query) => $query->where('status', $data['value'])))
                    )
                    ->preload(),

                SelectFilter::make('category')
                    ->options(fn () => 
                        Cache::remember('categories_announcement_count', 360, function () {
                            return Category::select('id', 'alternames', 'slug', 'parent_id')
                                ->with('announcements:id', 'parent')
                                ->get()
                                ->groupBy('parent.name')
                                ->map
                                ->pluck('nameWithAnnouncementCount', 'id');
                        })
                    )
                    ->query(fn ($query, $data) => 
                        $query->category(Category::find($data['value']))
                    ),

                SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
            ])
            ->persistFiltersInSession()
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->paginationPageOptions([25, 50, 100])
            ->poll('2s');
    }
}
