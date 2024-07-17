<?php

namespace App\Livewire\Admin;

use App\Jobs\CreateSeedersJob;
use App\Models\Attribute;
use App\Models\Category;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Artisan;

class Attributes extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    #[Layout('layouts.admin')]

    public $validation_rules = [
        'numeric' => 'Numeric', 
        'string' => 'String',
        'email' => 'Email',
        'phone' => 'Phone',
    ];

    public $type_options = [
        'select' => 'Select',
        'multiple_select' => 'Multiple select',
        'price' => 'Price',
        'price_from' => 'Price From',
        'text_input' => 'Text Input',
        'search' => 'Search',
        'search_in_description' => 'Search In Description',
        'text_area' => 'Text Area',
        'toggle_buttons' => 'Toggle Buttons',
        'toggle'    => 'Toggle',
        'between'   => 'Between',
        'from'  => 'From',
        'checkbox_list'   => 'Checkbox List',
        'location'  => 'Location',
        'hidden'    => 'Hidden',
        'markdown_editor' => 'Markdown Editor',
    ];
    
    public function table(Table $table): Table
    {
        return $table
            ->heading("All attributes: " . Attribute::count())
            ->query(Attribute::with('attribute_options'))
            ->groups([
                Group::make('section.slug')
                    ->getTitleFromRecordUsing(fn (Attribute $attribute): string => $attribute->section->name)
                    ->getDescriptionFromRecordUsing(fn (Attribute $attribute): string => $attribute->section->slug  . ", order: " . $attribute->section->order_number)
                    ->titlePrefixedWithLabel(false)
                    // ->orderQueryUsing(fn ($query, string $direction) => $query->orderByRaw('(select `attribute_sections`.`order_number` from `attribute_sections` where `attributes`.`attribute_section_id` = `attribute_sections`.`id` and `attribute_sections`.`deleted_at` is null) '. $direction))
                    ->collapsible(),
                Group::make('create_type')
                    ->getTitleFromRecordUsing(fn (Attribute $attribute): string => $this->type_options[$attribute->create_type])
                    ->titlePrefixedWithLabel(false)
                    ->collapsible(),
                Group::make('search_type')
                    ->getTitleFromRecordUsing(fn (Attribute $attribute): string => $this->type_options[$attribute->search_type])
                    ->titlePrefixedWithLabel(false)
                    ->collapsible(),
            ])
            ->defaultSort('order_number')
            ->defaultGroup('section.slug')
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order')
                    ->sortable()
                    ->grow(false),
                TextColumn::make('label')
                    ->description(fn (Attribute $attribute): string => $attribute->name),
                TextColumn::make('suffix'),
                SelectColumn::make('create_type')
                    ->grow(false)
                    ->options($this->type_options)
                    ->selectablePlaceholder(false),
                SelectColumn::make('search_type')
                    ->grow(false)
                    ->options($this->type_options)
                    ->selectablePlaceholder(false),
                TextColumn::make('attribute_options')
                    ->state(fn (Attribute $record) => $record->attribute_options->pluck('name'))
                    ->badge()
                    ->grow(false),
                ToggleColumn::make('searchable')
                    ->grow(false),
                ToggleColumn::make('filterable')
                    ->grow(false),
                ToggleColumn::make('is_feature')->disabled()
                    ->grow(false)
            ])
            ->headerActions([
                Action::make('Create seeder')
                    ->form([
                        Select::make('seeders')
                            ->multiple()
                            ->options([
                                'categories' => 'Category',
                                'attributes' => 'Attribute',
                                'attribute_category' => 'AttributeCategory',
                                'attribute_options' => 'AttributeOption',
                                'attribute_sections' => 'AttributeSection',
                            ])
                    ])
                    ->action(function (array $data) {
                        CreateSeedersJob::dispatch($data['seeders']);
                    })
                    ->hidden(app()->environment('production'))
                    ->slideOver()
                    ->closeModalByClickingAway(false),
                CreateAction::make()
                    ->model(Attribute::class)
                    ->icon('heroicon-o-plus-circle')
                    ->form([
                        Section::make(__('Categories'))
                            ->schema([
                                Select::make('categories')
                                    ->hiddenLabel()
                                    ->relationship('categories')
                                    ->multiple()
                                    ->options(Category::with('parent')->get()->groupBy('parent.name')->map->pluck('name', 'id')),
                            ]),
                        Section::make(__('Name'))
                            ->schema([
                                KeyValue::make('alterlabels')
                                    ->label(__('Label'))
                                    ->keyLabel(__('Language'))
                                    ->valueLabel(__('Value'))
                                    ->columnSpan(2)
                                    ->live(debounce: 500)
                                    ->default([
                                        'en' => '',
                                        'cs' => '',
                                        'ru' => '',
                                    ])
                                    ->required()
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('name', str()->snake($state['en']))),
                                TextInput::make('name')
                                    ->label(__('Name'))
                                    ->required()
                                    ->columnSpanFull(),
                                Toggle::make('has_suffix')
                                    ->label(__('Has suffix'))
                                    ->live()
                                    ->dehydrated(false)
                                    ->columnSpanFull(),
                                KeyValue::make('altersuffixes')
                                    ->label(__('Suffix'))
                                    ->keyLabel(__('Language'))
                                    ->valueLabel(__('Value'))
                                    ->default([
                                        'en' => '',
                                        'cs' => '',
                                        'ru' => '',
                                    ])
                                    ->afterStateHydrated(fn ($state, Set $set) => !empty($state) ? $set('has_suffix', true) : $set('has_suffix', false))
                                    ->visible(fn (Get $get) => $get('has_suffix') == true),
                            ])
                            ->columns(2),

                        Section::make(__('Types'))
                            ->schema([
                                Select::make('create_type')
                                    ->options($this->type_options)
                                    ->live(),
                                Select::make('search_type')
                                    ->options($this->type_options),
                                Toggle::make('translatable')
                                    ->helperText(__("Будет ли переводится этот атрибут автоматически"))
                                    ->live(),
                                Toggle::make('is_feature')
                                    ->helperText(__("Является ли этот атрибут характеристикой")),
                                Toggle::make('required')
                                    ->helperText(__("Является ли этот атрибут обязательным")),
                                Toggle::make('searchable')
                                    ->helperText(__("Будет ли атрибут показываться в поисковом запросе")),
                                Toggle::make('filterable')
                                    ->helperText(__("Можно ли фильовать по этому атрибуту")),
                                Toggle::make('always_required')
                                    ->helperText(__("Будет ли этот атрибут всегда обязательным и показываться вне зависимости от фильтрации")),
                                Select::make('rules')
                                    ->label('Validation rulles')
                                    ->multiple()
                                    ->columnSpanFull()
                                    ->options($this->validation_rules)
                            ])
                            ->columns(2),

                        Section::make(__('Options'))
                            ->schema([
                                Repeater::make('attribute_options')
                                    ->hiddenLabel()
                                    ->schema([
                                        KeyValue::make('alternames')
                                            ->label(__('Label'))
                                            ->keyLabel(__('Language'))
                                            ->valueLabel(__('Value'))
                                            ->default([
                                                'en' => '',
                                                'cs' => '',
                                                'ru' => '',
                                            ]),
                                        Toggle::make('is_default')
                                            ->fixIndistinctState(),
                                        Toggle::make('is_null')
                                            ->live(),
                                    ])
                                    ->relationship()
                                    ->reorderableWithButtons()
                                    ->reorderableWithDragAndDrop(false)
                                    ->cloneable()
                                    ->itemLabel(fn (array $state): ?string => ($state['alternames'][app()->getLocale()] ?? null) . ($state['is_default'] == true ? ", DEFAULT" : "") . ($state['is_null'] == true ? ", NULL" : ""))
                                    ->collapsed()
                                    ->columnSpanFull()
                            ])
                            ->hidden(fn (Get $get) => $get('create_type') != 'select' AND $get('create_type') != 'toggle_buttons'),

                        Section::make(__("Layout"))
                            ->schema([
                                Select::make('attribute_section_id')
                                    ->label('Section')
                                    ->relationship(name: 'section', titleAttribute: 'slug')
                                    ->columnSpanFull()
                                    ->createOptionForm([
                                        Section::make()
                                            ->schema([
                                                KeyValue::make('alternames')
                                                    ->label('Label')
                                                    ->keyLabel(__('Language'))
                                                    ->valueLabel(__('Value'))
                                                    ->columnSpan(2)
                                                    ->live(debounce: 500)
                                                    ->default([
                                                        'en' => '',
                                                        'cs' => '',
                                                        'ru' => '',
                                                    ])
                                                    ->required()
                                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state['en']))),
                                                TextInput::make('slug')
                                                    ->required(),
                                                TextInput::make('order_number')
                                                    ->required(),
                                            ])
                                            ->columns(2),
                                    ])
                                    ->editOptionForm([
                                        Section::make()
                                            ->schema([
                                                KeyValue::make('alternames')
                                                    ->label('Label')
                                                    ->keyLabel(__('Language'))
                                                    ->valueLabel(__('Value'))
                                                    ->columnSpan(2)
                                                    ->live(debounce: 500)
                                                    ->default([
                                                        'en' => '',
                                                        'cs' => '',
                                                        'ru' => '',
                                                    ])
                                                    ->required()
                                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state['en']))),
                                                TextInput::make('slug')
                                                    ->required(),
                                                TextInput::make('order_number')
                                                    ->required(),
                                            ])
                                            ->columns(2)
                                    ]),
                                TextInput::make('column_span')
                                    ->helperText(__("Сколько места внутри секции будет занимать этот атрибут (от 1 до 2)"))
                                    ->required(),
                                TextInput::make('column_start')
                                    ->helperText(__("В каком месте будет находиться этот атрибут в секции (от 1 до 2)"))
                                    ->required(),
                                TextInput::make('order_number')
                                    ->helperText(__("Порядковый номер этого атрибута в секции"))
                                    ->required(),
                            ])
                            ->columns(3),

                        Section::make(__('Visible/Hidden'))
                                ->schema([
                                    Grid::make(1)
                                        ->schema([
                                            Toggle::make('show_on_condition')
                                                ->label(__('Show on condition'))
                                                ->live()
                                                ->dehydrated(false)
                                                ->columnSpanFull(),
                                            Repeater::make('visible')
                                                ->schema([
                                                    Select::make('attribute_name')
                                                        ->label('Attribute')
                                                        ->options(function (Get $get) {
                                                            $categories = Category::whereIn('id',$get('../../categories'))->get()->map(function ($category) { 
                                                                return $category->getParentsAndSelf()->pluck('id'); 
                                                            })
                                                            ->flatten();

                                                            return Attribute::with('section')
                                                                ->whereHas('attribute_options')
                                                                ->whereHas('categories', fn ($query) => $query->whereIn('category_id', $categories ?? []))
                                                                ->get()
                                                                ->groupBy('section.slug')
                                                                ->map
                                                                ->pluck('label', 'name');
                                                        })
                                                        ->required()
                                                        ->live(),
                                                    Select::make('value')
                                                        ->options(fn (Get $get) => Attribute::whereName($get('attribute_name'))->first()?->attribute_options->pluck('name', 'id'))
                                                ])
                                                ->visible(fn (Get $get) => $get('show_on_condition'))
                                                ->afterStateHydrated(fn ($state, Set $set) => !empty($state) ? $set('show_on_condition', true) : $set('show_on_condition', false))
                                                ->defaultItems(1)
                                                ->hiddenLabel()
                                                ->columns(1)
                                        ])
                                        ->columnSpan(1),
                                    Grid::make(1)
                                        ->schema([
                                            Toggle::make('hide_on_condition')
                                                ->label(__('Hide on condition'))
                                                ->live()
                                                ->dehydrated(false),
                                            Repeater::make('hidden')
                                                ->schema([
                                                    Select::make('attribute_name')
                                                        ->label('Attribute')
                                                        ->options(function (Get $get) {
                                                            $categories = Category::whereIn('id',$get('../../categories'))->get()->map(function ($category) { 
                                                                return $category->getParentsAndSelf()->pluck('id'); 
                                                            })
                                                            ->flatten();

                                                            return Attribute::with('section')
                                                                ->whereHas('attribute_options')
                                                                ->whereHas('categories', fn ($query) => $query->whereIn('category_id', $categories ?? []))
                                                                ->get()
                                                                ->groupBy('section.slug')
                                                                ->map
                                                                ->pluck('label', 'name');
                                                        })
                                                        ->required()
                                                        ->live(),
                                                    Select::make('value')
                                                        ->options(fn (Get $get) => Attribute::whereName($get('attribute_name'))->first()?->attribute_options->pluck('name', 'id'))
                                                ])
                                                ->visible(fn (Get $get) => $get('hide_on_condition'))
                                                ->afterStateHydrated(fn ($state, Set $set) => !empty($state) ? $set('hide_on_condition', true) : $set('hide_on_condition', false))
                                                ->defaultItems(1)
                                                ->hiddenLabel()
                                                ->columns(1)
                                        ])
                                        ->columnSpan(1)
                                    
                                    
                                ])
                                ->columns(2),
                                
                    ])
                    ->slideOver()
                    ->closeModalByClickingAway(false),
                
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->form([
                            Section::make(__('Categories'))
                                ->schema([
                                    Select::make('categories')
                                        ->hiddenLabel()
                                        ->relationship('categories')
                                        ->multiple()
                                        ->options(Category::with('parent')->get()->groupBy('parent.name')->map->pluck('name', 'id')),
                                ]),
                            Section::make(__('Name'))
                                ->schema([
                                    KeyValue::make('alterlabels')
                                        ->label(__('Label'))
                                        ->keyLabel(__('Language'))
                                        ->valueLabel(__('Value'))
                                        ->columnSpan(2)
                                        ->live(debounce: 500)
                                        ->default([
                                            'en' => '',
                                            'cs' => '',
                                            'ru' => '',
                                        ])
                                        ->required()
                                        ->afterStateUpdated(fn ($state, callable $set) => $set('name', str()->snake($state['en']))),
                                    TextInput::make('name')
                                        ->label(__('Name'))
                                        ->required()
                                        ->columnSpanFull(),
                                    Toggle::make('has_suffix')
                                        ->label(__('Has suffix'))
                                        ->live()
                                        ->dehydrated(false)
                                        ->columnSpanFull(),
                                    KeyValue::make('altersuffixes')
                                        ->label(__('Suffix'))
                                        ->keyLabel(__('Language'))
                                        ->valueLabel(__('Value'))
                                        ->default([
                                            'en' => '',
                                            'cs' => '',
                                            'ru' => '',
                                        ])
                                        ->afterStateHydrated(fn ($state, Set $set) => !empty($state) ? $set('has_suffix', true) : $set('has_suffix', false))
                                        ->visible(fn (Get $get) => $get('has_suffix')),
                                ])
                                ->columns(2),

                            Section::make(__('Types'))
                                ->schema([
                                    Select::make('create_type')
                                        ->options($this->type_options)
                                        ->live(),
                                    Select::make('search_type')
                                        ->options($this->type_options),
                                    Toggle::make('translatable')
                                        ->live(),
                                    Toggle::make('is_feature'),
                                    Toggle::make('required'),
                                    Toggle::make('searchable'),
                                    Toggle::make('filterable'),
                                    Toggle::make('always_required'),
                                    Toggle::make('is_grouped')
                                        ->visible(fn (Get $get) => $get('create_type') == 'toggle_buttons' OR $get('search_type') == 'toggle_buttons'),
                                    Select::make('rules')
                                        ->label('Validation rulles')
                                        ->multiple()
                                        ->columnSpanFull()
                                        ->options($this->validation_rules)
                                ])
                                ->columns(2),

                            Section::make(__('Options'))
                                ->schema([
                                    Repeater::make('attribute_options')
                                        ->hiddenLabel()
                                        ->schema([
                                            KeyValue::make('alternames')
                                                ->label(__('Label'))
                                                ->keyLabel(__('Language'))
                                                ->valueLabel(__('Value'))
                                                ->default([
                                                    'en' => '',
                                                    'cs' => '',
                                                    'ru' => '',
                                                ]),
                                            Toggle::make('is_default')
                                                ->fixIndistinctState(),
                                            Toggle::make('is_null')
                                                ->live(),
                                        ])
                                        ->relationship()
                                        ->reorderableWithButtons()
                                        ->reorderableWithDragAndDrop(false)
                                        ->cloneable()
                                        ->itemLabel(fn (array $state): ?string => ($state['alternames'][app()->getLocale()] ?? null) . ($state['is_default'] == true ? ", DEFAULT" : "") . ($state['is_null'] == true ? ", NULL" : ""))
                                        ->collapsed()
                                        ->columnSpanFull()
                                ])
                                ->hidden(fn (Get $get) => $get('create_type') != 'select' AND $get('create_type') != 'toggle_buttons'),

                            Section::make(__("Layout"))
                                ->schema([
                                    Select::make('attribute_section_id')
                                        ->label('Section')
                                        ->relationship(name: 'section', titleAttribute: 'slug')
                                        ->columnSpanFull()
                                        ->createOptionForm([
                                            Section::make()
                                                ->schema([
                                                    KeyValue::make('alternames')
                                                        ->label('Label')
                                                        ->keyLabel(__('Language'))
                                                        ->valueLabel(__('Value'))
                                                        ->columnSpan(2)
                                                        ->live(debounce: 500)
                                                        ->default([
                                                            'en' => '',
                                                            'cs' => '',
                                                            'ru' => '',
                                                        ])
                                                        ->required()
                                                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state['en']))),
                                                    TextInput::make('slug')
                                                        ->required(),
                                                    TextInput::make('order_number')
                                                        ->required(),
                                                ])
                                                ->columns(2),
                                        ])
                                        ->editOptionForm([
                                            Section::make()
                                                ->schema([
                                                    KeyValue::make('alternames')
                                                        ->label('Label')
                                                        ->keyLabel(__('Language'))
                                                        ->valueLabel(__('Value'))
                                                        ->columnSpan(2)
                                                        ->live(debounce: 500)
                                                        ->default([
                                                            'en' => '',
                                                            'cs' => '',
                                                            'ru' => '',
                                                        ])
                                                        ->required()
                                                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state['en']))),
                                                    TextInput::make('slug')
                                                        ->required(),
                                                    TextInput::make('order_number')
                                                        ->required(),
                                                ])
                                                ->columns(2)
                                        ]),
                                    TextInput::make('column_span')
                                        ->helperText(__("Сколько места внутри секции будет занимать этот атрибут (от 1 до 2)"))
                                        ->required(),
                                    TextInput::make('column_start')
                                        ->helperText(__("В каком месте будет находиться этот атрибут в секции (от 1 до 2)"))
                                        ->required(),
                                    TextInput::make('order_number')
                                        ->helperText(__("Порядковый номер этого атрибута в секции"))
                                        ->required(),
                                ])
                                ->columns(3),

                            Section::make(__('Visible/Hidden'))
                                    ->schema([
                                        Grid::make(1)
                                            ->schema([
                                                Toggle::make('show_on_condition')
                                                    ->label(__('Show on condition'))
                                                    ->live()
                                                    ->dehydrated(false)
                                                    ->columnSpanFull(),
                                                Repeater::make('visible')
                                                    ->schema([
                                                        Select::make('attribute_name')
                                                            ->label('Attribute')
                                                            ->options(function (Get $get) {
                                                                $categories = Category::whereIn('id',$get('../../categories'))->get()->map(function ($category) { 
                                                                    return $category->getParentsAndSelf()->pluck('id'); 
                                                                })
                                                                ->flatten();

                                                                return Attribute::with('section')
                                                                    ->whereHas('attribute_options')
                                                                    ->whereHas('categories', fn ($query) => $query->whereIn('category_id', $categories ?? []))
                                                                    ->get()
                                                                    ->groupBy('section.slug')
                                                                    ->map
                                                                    ->pluck('label', 'name');
                                                            })
                                                            ->required()
                                                            ->live(),
                                                        Select::make('value')
                                                            ->options(fn (Get $get) => Attribute::whereName($get('attribute_name'))->first()?->attribute_options->pluck('name', 'id'))
                                                    ])
                                                    ->visible(fn (Get $get) => $get('show_on_condition'))
                                                    ->afterStateHydrated(fn ($state, Set $set) => !empty($state) ? $set('show_on_condition', true) : $set('show_on_condition', false))
                                                    ->defaultItems(1)
                                                    ->hiddenLabel()
                                                    ->columns(1)
                                            ])
                                            ->columnSpan(1),
                                        Grid::make(1)
                                            ->schema([
                                                Toggle::make('hide_on_condition')
                                                    ->label(__('Hide on condition'))
                                                    ->live()
                                                    ->dehydrated(false),
                                                Repeater::make('hidden')
                                                    ->schema([
                                                        Select::make('attribute_name')
                                                            ->label('Attribute')
                                                            ->options(function (Get $get) {
                                                                $categories = Category::whereIn('id',$get('../../categories'))->get()->map(function ($category) { 
                                                                    return $category->getParentsAndSelf()->pluck('id'); 
                                                                })
                                                                ->flatten();

                                                                return Attribute::with('section')
                                                                    ->whereHas('attribute_options')
                                                                    ->whereHas('categories', fn ($query) => $query->whereIn('category_id', $categories ?? []))
                                                                    ->get()
                                                                    ->groupBy('section.slug')
                                                                    ->map
                                                                    ->pluck('label', 'name');
                                                            })
                                                            ->required()
                                                            ->live(),
                                                        Select::make('value')
                                                            ->options(fn (Get $get) => Attribute::whereName($get('attribute_name'))->first()?->attribute_options->pluck('name', 'id'))
                                                    ])
                                                    ->visible(fn (Get $get) => $get('hide_on_condition'))
                                                    ->afterStateHydrated(fn ($state, Set $set) => !empty($state) ? $set('hide_on_condition', true) : $set('hide_on_condition', false))
                                                    ->defaultItems(1)
                                                    ->hiddenLabel()
                                                    ->columns(1)
                                            ])
                                            ->columnSpan(1)
                                        
                                        
                                    ])
                                    ->columns(2),
                                    
                        ])
                        ->slideOver()
                        ->closeModalByClickingAway(false),
                    DeleteAction::make()
                ])
            ])
            ->paginated(false);
    }
    public function render()
    {
        return view('livewire.admin.attributes');
    }
}
