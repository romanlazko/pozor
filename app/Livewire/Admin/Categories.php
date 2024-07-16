<?php

namespace App\Livewire\Admin;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\TelegramChat;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
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
use Livewire\Attributes\Layout;
use Livewire\Component;

class Categories extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    
    #[Layout('layouts.admin')]
    public $category;

    public $category_attributes;

    public function mount($category = null)
    {
        if ($category) {
            $this->category = Category::find($category);
        }

        $this->category_attributes = Attribute::with('section')
            ->when($category, function ($query) {
                return $query->whereNotIn('id', $this->category->getParentsAndSelf()->pluck('attributes')->flatten()->pluck('id')->toArray());
            })
            ->get()->groupBy('section.slug')->map->pluck('label', 'id')->toArray();
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->heading($this->category?->name ?? "All categories")
            ->query(Category::where('parent_id', $this->category?->id ?? null)->with('children', 'attributes', 'channels'))
            ->columns([
                SpatieMediaLibraryImageColumn::make('image')
                    ->collection('categories')
                    ->conversion('thumb'),
                TextColumn::make('name')
                    ->url(fn (Category $category): string => route('admin.categories', $category)),
                ToggleColumn::make('is_active'),
                TextColumn::make('children')
                    ->state(function (Category $record) {
                        return $record->children->pluck('name');
                    })
                    ->badge()
                    ->color('success'),
                TextColumn::make('attributes')
                    ->state(function (Category $record) {
                        return $record->attributes->pluck('label');
                    })
                    ->badge(),
                TextColumn::make('channels')
                    ->state(function (Category $record) {
                        return $record->channels->pluck('title');
                    })
                    ->color('warning')
                    ->badge(),
            ])
            ->headerActions([
                Action::make('back')
                    ->icon('heroicon-o-arrow-left-circle')
                    ->url(route('admin.categories', $this->category?->parent?->id))
                    ->hidden(fn () => $this->category == null),
                CreateAction::make()
                    ->model(Category::class)
                    ->icon('heroicon-o-plus-circle')
                    ->form([
                        Section::make()
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        Grid::make(1)
                                            ->schema([
                                                SpatieMediaLibraryFileUpload::make('Image')
                                                    ->collection('categories')
                                                    ->conversion('thumb')
                                                    ->imageEditor(),
                                            ])
                                            ->columnSpan(2),
                                        Grid::make(1)
                                            ->schema([
                                                Select::make('attributes')
                                                    ->relationship('attributes')
                                                    ->multiple()
                                                    ->options($this->category_attributes),
                                            ])
                                            ->columnSpan(2)
                                ]),
                        ])
                        ->columnSpan(1),
                    
                        Section::make()
                            ->schema([
                                KeyValue::make('alternames')
                                    ->keyLabel('Lang')
                                    ->default([
                                        'en' => '',
                                        'cs' => '',
                                        'ru' => '',
                                    ]),
                                TextInput::make('parent_id')
                                    ->hiddenLabel()
                                    ->default($this->category?->id ?? null)
                                    ->extraAttributes([
                                        'class' => 'hidden'
                                    ])
                            ])
                            ->columns(1),
                    ])
                                
                    ->slideOver()
                    ->closeModalByClickingAway(false),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->record($this->category)
                        ->form([
                            Section::make()
                                ->schema([
                                    Grid::make(4)
                                        ->schema([
                                            Grid::make(1)
                                                ->schema([
                                                    SpatieMediaLibraryFileUpload::make('Image')
                                                        ->collection('categories')
                                                        ->conversion('thumb')
                                                        ->imageEditor(),
                                                ])
                                                ->columnSpan(2),
                                            Grid::make(1)
                                                ->schema([
                                                    Select::make('attributes')
                                                        ->relationship('attributes')
                                                        ->multiple()
                                                        ->options($this->category_attributes),
                                                ])
                                                ->columnSpan(2)
                                    ]),
                            ])
                            ->columnSpan(1),
                        
                            Section::make()
                                ->schema([
                                    KeyValue::make('alternames')
                                        ->keyLabel('Lang')
                                        ->default([
                                            'en' => '',
                                            'cs' => '',
                                            'ru' => '',
                                        ]),
                                    TextInput::make('parent_id')
                                        ->hiddenLabel()
                                        ->default($this->category?->id ?? null)
                                        ->extraAttributes([
                                            'class' => 'hidden'
                                        ])
                                ])
                                ->columns(1),
                            Section::make()
                                ->schema([
                                    Select::make('channels')
                                        ->relationship('channels')
                                        ->multiple()
                                        ->options(TelegramChat::where('type', 'channel')->pluck('title', 'id'))
                                ])
                        ])
                        ->slideOver()
                        ->closeModalByClickingAway(false),
                    DeleteAction::make()
                        ->record($this->category)
                ])
            ]);
    }
    public function render()
    {
        return view('livewire.admin.categories');
    }
}
