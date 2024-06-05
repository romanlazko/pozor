<?php

namespace App\Livewire\Admin;

use App\Enums\Status;
use App\Livewire\Components\Tables\Columns\ImageGridColumn;
use App\Models\Announcement;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class Announcements extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    #[Layout('layouts.admin')]

    public function render()
    {
        return view('livewire.admin.announcements');
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading("All announcements")
            ->query(Announcement::with('media', 'user.media'))
            ->columns([
                Stack::make([
                    TextColumn::make('status')
                            ->getStateUsing(fn (Announcement $announcement) => $announcement->status)
                            ->badge()
                            ->color(fn (Announcement $announcement) => $announcement->status->filamentColor())
                            ->grow(false),
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
                                ->label('User')
                                ->description(fn (Announcement $announcement) => $announcement->user?->email)
                        ])
                            
                    ]),
                    
                    ImageGridColumn::make('image')
                        ->collection('announcements')
                        ->height(200)
                        ->extraAttributes(['class' => 'w-full']),
                    
                    TextColumn::make('Title')
                        ->wrap()
                        ->state(fn (Announcement $announcement) => $announcement->getFeatureByName('title')?->value)
                        ->description(fn (Announcement $announcement) => 
                            new HtmlString(
                                app(MarkdownRenderer::class)->toHtml($announcement->getFeatureByName('description')?->value ?? '')
                            )
                        )
                        ->extraAttributes([
                            'class' => 'html'
                        ]),
                    Split::make([
                        TextColumn::make('attr')
                            ->state(fn (Announcement $announcement) => $announcement->features->where('attribute.is_feature')->map(function ($feature) {
                                return $feature->label . ': ' . $feature->value;
                            }))
                            ->badge()
                            ->color('gray')
                            ->wrap()
                    ])
                    ->extraAttributes(['class' => 'overflow-auto'])
                    ->collapsible(),

                TextColumn::make('should_be_published_in_telegram')
                    ->formatStateUsing(fn () => 'Telegram publishing')
                    ->icon(fn (string $state): string => match ($state) {
                        '1' => 'heroicon-o-check-circle',
                        '0' => 'heroicon-o-x-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'success',
                        '0' => 'danger',
                    })
                    ->badge()
                ])
                ->extraAttributes(['class' => 'overflow-auto space-y-2'])
            ])
            
            ->actions([
                    // create status

                    Action::make('send_to_moderation')
                        ->label(__("Send to moderation"))
                        ->action(fn (Announcement $announcement) => 
                            $announcement->status->isCreated() 
                                ? $announcement->moderate() 
                                : null
                        )
                        ->color('info')
                        ->button()
                        ->icon('heroicon-m-arrow-right-circle')
                        ->visible(fn (Announcement $announcement) => 
                            $announcement->status->isCreated()
                        )
                        ->size(ActionSize::ExtraSmall),

                    // await_moderation OR moderation_not_passed OR moderation_failed status

                    Action::make('approve')
                        ->label(__("Approve"))
                        ->action(fn (Announcement $announcement) => 
                            $announcement->status->isOnModeration() 
                                ? $announcement->approve() 
                                : null
                        )
                        ->color('info')
                        ->button()
                        ->icon('heroicon-s-check-circle')
                        ->visible(fn (Announcement $announcement) => 
                            $announcement->status->isOnModeration()
                        )
                        ->size(ActionSize::ExtraSmall),

                    Action::make('reject')
                        ->label(__("Reject"))
                        ->form([
                            Section::make()
                                ->schema([
                                    Textarea::make('reject_reason')
                                        ->label(__("Reason"))
                                        ->required()
                                        ->rows(6),
                                ])
                        ])
                        ->action(fn (array $data, Announcement $announcement) => 
                            $announcement->status->isOnModeration() 
                                ? $announcement->reject($data['reject_reason'])
                                : null
                        )
                        ->color('danger')
                        ->button()
                        ->icon('heroicon-c-no-symbol')
                        ->slideOver()
                        ->modalWidth('md')
                        ->visible(fn (Announcement $announcement) => 
                            $announcement->status->isOnModeration()
                        )
                        ->size(ActionSize::ExtraSmall),
                        
                    // approved status

                    Action::make('translate')
                        ->label(__("Translate"))
                        ->action(fn (Announcement $announcement) => 
                            $announcement->status->isApproved() 
                                ? $announcement->translate() 
                                : null
                        )
                        ->color('info')
                        ->button()
                        ->icon('heroicon-c-language')
                        ->visible(fn (Announcement $announcement) => 
                            $announcement->status->isApproved()
                        )
                        ->size(ActionSize::ExtraSmall),

                    

                    // await_translation translation_failed status

                    Action::make('stop_translating')
                        ->label(__("Stop translating"))
                        ->action(fn (Announcement $announcement) => 
                            $announcement->status->isAwaitTranslation()
                                ? $announcement->translationFailed()
                                : null
                        )
                        ->color('danger')
                        ->button()
                        ->icon('heroicon-c-no-symbol')
                        ->visible(fn (Announcement $announcement) => 
                            $announcement->status->isAwaitTranslation()
                        )
                        ->size(ActionSize::ExtraSmall),

                    Action::make('retry_translation')
                        ->label(__("Retry translation"))
                        ->action(fn (Announcement $announcement) => 
                            $announcement->status->isTranslationFailed() 
                                ? $announcement->translate() 
                                : null
                        )
                        ->color('warning')
                        ->button()
                        ->icon('heroicon-c-arrow-path-rounded-square')
                        ->visible(fn (Announcement $announcement) => 
                            $announcement->status->isTranslationFailed()
                        )
                        ->size(ActionSize::ExtraSmall),

                    // await_publication status

                    Action::make('stop_publishing')
                        ->label(__("Stop publishing"))
                        ->action(fn (Announcement $announcement) => 
                            $announcement->status->isAwaitPublication() 
                                ? $announcement->publishingFailed() 
                                : null
                        )
                        ->color('danger')
                        ->button()
                        ->icon('heroicon-c-no-symbol')
                        ->visible(fn (Announcement $announcement) => 
                            $announcement->status->isAwaitPublication()
                        )
                        ->size(ActionSize::ExtraSmall),
                    
                    // publishing_failed status

                    Action::make('retry_publication')
                        ->label(__("Retry publication"))
                        ->action(fn (Announcement $announcement) => 
                            $announcement->status->isPublishingFailed() 
                                ? $announcement->publish() 
                                : null
                        )
                        ->color('warning')
                        ->button()
                        ->icon('heroicon-c-arrow-path-rounded-square')
                        ->visible(fn (Announcement $announcement) => 
                            $announcement->status->isPublishingFailed()
                        )
                        ->size(ActionSize::ExtraSmall),

                    // translated status

                    // Action::make('publish')
                    //     ->label(__("Publish"))
                    //     ->action(fn (Announcement $announcement) => $announcement->publish())
                    //     ->color('success')
                    //     ->button()
                    //     ->visible(fn (Announcement $announcement) => 
                    //         $announcement->status->isTranslated()
                    //     ),

                    ActionGroup::make([
                        Action::make('Enable Telegram Publishing')
                            ->action(fn (Announcement $announcement) => $announcement->update(['should_be_published_in_telegram' => true]))
                            ->visible(fn (Announcement $announcement) => $announcement->should_be_published_in_telegram == false)
                            ->icon('heroicon-o-check-circle')
                            ->color('success'),
                        Action::make('Disable Telegram Publishing')
                            ->action(fn (Announcement $announcement) => $announcement->update(['should_be_published_in_telegram' => false]))
                            ->visible(fn (Announcement $announcement) => $announcement->should_be_published_in_telegram == true)
                            ->icon('heroicon-o-x-circle')
                            ->color('danger'),
                        Action::make('publish_without_translating')
                            ->label(__("Publish without translating"))
                            ->action(fn (Announcement $announcement) => 
                                ($announcement->status->isOnTranslation() OR $announcement->status->isApproved())
                                    ? $announcement->publish() 
                                    : null
                            )
                            ->color('warning')
                            ->icon('heroicon-c-no-symbol')
                            ->visible(fn (Announcement $announcement) => 
                                $announcement->status->isOnTranslation()
                                OR $announcement->status->isApproved()
                            ),

                        ViewAction::make('audits')
                            ->label(__("View audits"))
                            ->url(fn (Announcement $announcement) => route('admin.announcement.audit', $announcement->id)),
                        // ViewAction::make('view_images')
                        //     ->label(__("View Images"))
                        //     ->form([
                        //         SpatieMediaLibraryFileUpload::make('image')
                        //             ->hiddenLabel()
                        //             ->collection('announcements')
                        //             ->multiple()
                        //             ->image(),
                        //     ])
                        //     ->slideOver(),
                        
                        Action::make('change_status')
                            ->label(__("Change Status"))
                            ->icon('heroicon-c-arrow-path-rounded-square')
                            ->form(fn (Announcement $announcement) => [
                                Section::make()
                                    ->schema([
                                        Select::make('status')
                                            ->options(Status::class)
                                            ->default($announcement->status)
                                    ])
                            ])
                            ->action(function (array $data, Announcement $announcement): void {
                                $announcement->update([
                                    'status' => $data['status'],
                                ]);
                            })
                            ->modalWidth('md')
                            ->slideOver(),
                        DeleteAction::make(),
                    ])
                    ->size(ActionSize::ExtraSmall)
                    ->dropdownPlacement('right-start')
                    ->button()
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(Status::class)
                    ->default(Status::await_moderation->value),
                // SelectFilter::make('category')
                //     ->relationship('categories', 'name'),
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
