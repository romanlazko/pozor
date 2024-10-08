<?php

namespace App\Livewire\Admin;

use App\Jobs\CreateSeedersJob;
use App\Models\Attribute;
use App\Models\AttributeGroup;
use App\Models\AttributeSection;
use App\Models\Category;
use Closure;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class Attributes extends BaseAdminLayout implements HasForms, HasTable
{
    public $categories;

    public $validation_rules = [
        'numeric' => 'Только число', 
        'string' => 'Только строка',
        'email' => 'Email',
        'phone' => 'Phone',
    ];

    public $type_options = [
        'fields_with_options' => [
            'select' => 'SELECT (выбор одного элемента из списка)',
            'multiple_select' => 'MULTIPLE SELECT (выбор нескольких элементов из списка)',
            'toggle_buttons' => 'TOGGLE BUTTONS (выбор переключателей)',
            'checkbox_list'   => 'CHECKBOX LIST (список чекбоксов)',
            'price' => 'PRICE (цена)',
        ],
        'text_fields' => [
            'text_input' => 'Текстовое поле',
            'text_area' => 'Текстовый блок',
            'between'   => 'Между',
            'from_to'   => 'From-To',
            'markdown_editor' => 'Markdown Editor',
        ],
        'other' => [
            'location'  => 'Местоположение',
            'hidden'    => 'Скрытое поле',
        ],
        'date' => [
            'date' => 'Date',
            'date_time' => 'Date Time',
            'month_year' => 'Month Year',
        ]
    ];

    public function mount(): void
    {
        $this->categories = Category::all()->groupBy('parent.name')->map->pluck('name', 'id');
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->heading("All attributes: " . Attribute::count())
            ->query(Attribute::query())
            ->groups([
                Group::make('filterSection.slug')
                    ->getTitleFromRecordUsing(fn (Attribute $attribute): string => $attribute?->filterSection?->name ?? 'null')
                    ->getDescriptionFromRecordUsing(fn (Attribute $attribute): string => "#{$attribute?->filterSection?->order_number} - {$attribute?->filterSection?->slug}")
                    ->titlePrefixedWithLabel(false)
                    ->collapsible(),
                Group::make('createSection.slug')
                    ->getTitleFromRecordUsing(fn (Attribute $attribute): string => $attribute?->createSection?->name ?? 'null')
                    ->getDescriptionFromRecordUsing(fn (Attribute $attribute): string => "#{$attribute?->createSection?->order_number} - {$attribute?->createSection?->slug}")
                    ->titlePrefixedWithLabel(false)
                    ->collapsible(),
                Group::make('showSection.slug')
                    ->getTitleFromRecordUsing(fn (Attribute $attribute): string => $attribute?->showSection?->name ?? 'null')
                    ->getDescriptionFromRecordUsing(fn (Attribute $attribute): string => "#{$attribute?->showSection?->order_number} - {$attribute?->showSection?->slug}")
                    ->titlePrefixedWithLabel(false)
                    ->collapsible(),
            ])
            ->defaultSort(function () use ($table){
                return match ($table->getGrouping()?->getRelationshipName()) {
                    'filterSection' => 'filter_layout->order_number',
                    'createSection' => 'create_layout->order_number',
                    'showSection' => 'show_layout->order_number',
                    default => 'created_at',
                };
            })
            ->defaultGroup('createSection.slug')
            ->columns([
                TextColumn::make('order')
                    ->state(fn (Attribute $attribute) => match ($table->getGrouping()?->getRelationshipName()) {
                        'filterSection' => $attribute->filter_layout['order_number'] ?? 0,
                        'createSection' => $attribute->create_layout['order_number'] ?? 0,
                        'showSection' => $attribute->show_layout['order_number'] ?? 0,
                        default => null,
                    }),

                TextColumn::make('label')
                    ->description(fn (Attribute $attribute): string =>  $attribute?->name . ($attribute?->suffix ? " ({$attribute?->suffix})" : '')),

                TextColumn::make('Layout')
                    ->state(function (Attribute $attribute) {
                        $string = function ($layout_name, $layout) {
                            $type = $layout['type'] ?? null;
                            $order_number = $layout['order_number'] ?? null;
                            return "#{$order_number} - {$layout_name}: {$type}";
                        };
                        return [
                            $string('filterSection', $attribute->filter_layout),
                            $string('createSection', $attribute->create_layout),
                            $string('showSection', $attribute->show_layout),
                        ];
                    })
                    ->badge()
                    ->color('warning'),

                TextColumn::make('group.slug')
                    ->badge()
                    ->state(fn (Attribute $record) => $record->group ? "#{$record->group_layout['order_number']} - {$record->group?->slug}": null)
                    ->color('danger'),
                    
                TextColumn::make('create_layout.rules')
                    ->label('Rules')
                    ->badge()
                    ->color('danger'),

                TextColumn::make('attribute_options')
                    ->state(fn (Attribute $record) => $record->attribute_options->pluck('name'))
                    ->badge()
                    ->grow(false),

                TextColumn::make('categories')
                    ->state(fn (Attribute $record) => $record->categories->pluck('name'))
                    ->badge()
                    ->color('success')
                    ->grow(false),
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
                                'attribute_groups' => 'Groups',
                                'media' => 'Media',
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
                                Grid::make(2)
                                    ->schema([
                                        Select::make('categories')
                                            ->helperText("Категории к которым принадлежит атрибут. (можно выбрать несколько)")
                                            ->relationship('categories')
                                            ->multiple()
                                            ->options($this->categories)
                                            ->columnSpanFull(),
                                    ])
                                    ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),
                            ]),

                        Section::make(__('Name'))
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        KeyValue::make('alterlabels')
                                            ->label(__('Label'))
                                            ->helperText("Лейбел атрибута. Будет виден пользователю в виде названия поля.")
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
                                            ->afterStateUpdated(fn ($state, Set $set) => $set('name', str()->snake($state['en'])))
                                            ->rules([
                                                fn (): Closure => function (string $attribute, $value, Closure $fail) {
                                                    if (!isset($value['en']) OR $value['en'] == '') 
                                                        $fail('The :attribute must contain english translation.');
                                                },
                                            ]),
                                        TextInput::make('name')
                                            ->label(__('Slug'))
                                            ->required()
                                            ->columnSpanFull()
                                            ->unique(),
                                    ])
                                    ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),

                                Grid::make(2)
                                    ->schema([
                                        Toggle::make('has_suffix')
                                            ->label(__('Has suffix'))
                                            ->live()
                                            ->dehydrated(false)
                                            ->default(false)
                                            ->columnSpanFull()
                                            ->afterStateUpdated(fn ($state, Set $set) => 
                                                $set('altersuffixes', $state 
                                                    ? [
                                                        'en' => '',
                                                        'cs' => '',
                                                        'ru' => '',
                                                    ] 
                                                    : [])
                                            ),

                                        KeyValue::make('altersuffixes')
                                            ->label(__('Suffix'))
                                            ->keyLabel(__('Language'))
                                            ->valueLabel(__('Value'))
                                            ->rules([
                                                fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                                    if ($get('has_suffix') AND (!isset($value['en']) OR $value['en'] === '')) 
                                                        $fail('The :attribute must contain english translation.');
                                                },
                                            ])
                                            ->dehydratedWhenHidden('true')
                                            ->afterStateHydrated(fn ($state, Set $set) => $set('has_suffix', !empty(array_filter($state ?? []))))
                                            ->visible(fn (Get $get) => $get('has_suffix')),
                                    ])
                                    ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),
                            ])
                            ->columns(2),

                        Section::make(__("Create layout"))
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Select::make('create_layout.type')
                                            ->options($this->type_options)
                                            ->required()
                                            ->helperText("Тип атрибута при создании объявления.")
                                            ->afterStateUpdated(function (Get $get, Set $set, $state) { 
                                                !$get('filter_layout.type')
                                                    ? $set('filter_layout.type', $state) 
                                                    : null;
                                                $set('show_layout.type', $state);
                                            })
                                            ->columnSpanFull()
                                            ->live(),
                                        
                                        Select::make('create_layout.rules')
                                            ->label('Validation rulles')
                                            ->multiple()
                                            ->required()
                                            ->columnSpanFull()
                                            ->options($this->validation_rules)
                                            ->visible(fn (Get $get) => in_array($get('create_layout.type'), array_keys($this->type_options['text_fields']))),
                                    ])
                                    ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),
                                
                                Grid::make(3)  
                                    ->schema([
                                        Select::make('create_layout.section_id')
                                            ->label('Section')
                                            ->helperText(__('Секция в которой будет находится этот атрибут'))
                                            ->relationship(name: 'createSection', modifyQueryUsing: fn (Builder $query) => $query->orderBy('order_number'))
                                            ->getOptionLabelFromRecordUsing(fn (AttributeSection $record) => "#{$record->order_number} - {$record->name} ({$record->slug})")
                                            ->columnSpanFull()
                                            ->required()
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
                                                            ->rules([
                                                                fn (): Closure => function (string $attribute, $value, Closure $fail) {
                                                                    if (!isset($value['en']) OR $value['en'] == '') 
                                                                        $fail('The :attribute must contain english translation.');
                                                                },
                                                            ])
                                                            ->required()
                                                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state['en']))),

                                                        TextInput::make('slug')
                                                            ->required(),

                                                        TextInput::make('order_number')
                                                            ->helperText(__('Порядковый номер секции внутри формы.'))
                                                            ->numeric()
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
                                                            ->rules([
                                                                fn (): Closure => function (string $attribute, $value, Closure $fail) {
                                                                    if (!isset($value['en']) OR $value['en'] == '') 
                                                                        $fail('The :attribute must contain english translation.');
                                                                },
                                                            ])
                                                            ->required()
                                                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state['en']))),

                                                        TextInput::make('slug')
                                                            ->required(),

                                                        TextInput::make('order_number')
                                                            ->helperText(__('Порядковый номер секции внутри формы.'))
                                                            ->numeric()
                                                            ->required(),
                                                    ])
                                                    ->columns(2)
                                            ])
                                            ->afterStateUpdated(fn (Get $get, Set $set) => 
                                                !$get('filter_layout.section_id')
                                                    ? $set('filter_layout.section_id', $get('create_layout.section_id')) 
                                                    : null
                                            )
                                            ->live(),

                                        TextInput::make('create_layout.column_span')
                                            ->helperText(__("Сколько места по ширине, внутри секции, будет занимать этот атрибут (от 1 до 4)"))
                                            ->afterStateUpdated(fn (Get $get, Set $set) => 
                                                !$get('filter_layout.column_span')
                                                    ? $set('filter_layout.column_span', $get('create_layout.column_span')) 
                                                    : null
                                            )
                                            ->live()
                                            ->required(),

                                        TextInput::make('create_layout.column_start')
                                            ->helperText(__("В каком месте в линии будет находиться этот атрибут в секции (от 1 до 4)"))
                                            ->afterStateUpdated(fn (Get $get, Set $set) => 
                                                !$get('filter_layout.column_start')
                                                    ? $set('filter_layout.column_start', $get('create_layout.column_start')) 
                                                    : null
                                            )
                                            ->live()
                                            ->required(),

                                        TextInput::make('create_layout.order_number')
                                            ->helperText(__("Порядковый номер этого атрибута внутри секции"))
                                            ->afterStateUpdated(fn (Get $get, Set $set) => 
                                                !$get('filter_layout.order_number')
                                                    ? $set('filter_layout.order_number', $get('create_layout.order_number')) 
                                                    : null
                                            )
                                            ->live()
                                            ->required(),
                                    ])
                                    ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),
                                
                                Grid::make(3)
                                    ->schema([
                                        Toggle::make('is_feature')
                                            ->helperText(__("Является ли этот атрибут характеристикой")),

                                        Toggle::make('translatable')
                                            ->helperText(__("Будет ли переводится этот атрибут автоматически"))
                                            ->visible(fn (Get $get) => in_array($get('create_layout.type'), array_keys($this->type_options['text_fields']))),

                                        Toggle::make('required')
                                            ->helperText(__("Является ли этот атрибут обязательным при создании объявления")),
                                    ])
                                    ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),
                            ])
                            ->columns(3),

                        Section::make(__("Filter layout"))
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Select::make('filter_layout.type')
                                            ->options($this->type_options)
                                            ->required()
                                            ->live()
                                            ->helperText("Тип атрибута при поиске.")
                                            ->columnSpanFull(),
                                    ])
                                    ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),
                                Grid::make(3)
                                    ->schema([
                                        Select::make('filter_layout.section_id')
                                            ->label('Section')
                                            ->helperText(__('Секция в которой будет находится этот атрибут'))
                                            ->relationship(name: 'filterSection', modifyQueryUsing: fn (Builder $query) => $query->orderBy('order_number'))
                                            ->getOptionLabelFromRecordUsing(fn (AttributeSection $record) => "#{$record->order_number} - {$record->name} ({$record->slug})")
                                            ->columnSpanFull()
                                            ->required()
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
                                                            ->rules([
                                                                fn (): Closure => function (string $attribute, $value, Closure $fail) {
                                                                    if (!isset($value['en']) OR $value['en'] == '') 
                                                                        $fail('The :attribute must contain english translation.');
                                                                },
                                                            ])
                                                            ->required()
                                                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state['en']))),

                                                        TextInput::make('slug')
                                                            ->required(),

                                                        TextInput::make('order_number')
                                                            ->helperText(__('Порядковый номер секции внутри формы.'))
                                                            ->numeric()
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
                                                            ->rules([
                                                                fn (): Closure => function (string $attribute, $value, Closure $fail) {
                                                                    if (!isset($value['en']) OR $value['en'] == '') 
                                                                        $fail('The :attribute must contain english translation.');
                                                                },
                                                            ])
                                                            ->required()
                                                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state['en']))),

                                                        TextInput::make('slug')
                                                            ->required(),

                                                        TextInput::make('order_number')
                                                            ->helperText(__('Порядковый номер секции внутри формы.'))
                                                            ->numeric()
                                                            ->required(),
                                                    ])
                                                    ->columns(2)
                                            ]),
                                        TextInput::make('filter_layout.column_span')
                                            ->helperText(__("Сколько места по ширине, внутри секции, будет занимать этот атрибут (от 1 до 4)"))
                                            ->required(),

                                        TextInput::make('filter_layout.column_start')
                                            ->helperText(__("В каком месте (слева или справа) будет находиться этот атрибут в секции (от 1 до 4)"))
                                            ->required(),

                                        TextInput::make('filter_layout.order_number')
                                            ->helperText(__("Порядковый номер этого атрибута внутри секции"))
                                            ->required()
                                    ])
                                    ->hidden(fn (Get $get) => $get('filter_layout.type') == 'hidden')
                                    ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),
                            ])
                            ->columns(3),

                        Section::make(__("Show layout"))
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Select::make('show_layout.type')
                                            ->options($this->type_options)
                                            ->required()
                                            ->live(),
                                    ])
                                    ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),

                                Grid::make(3)
                                    ->schema([
                                        Select::make('show_layout.section_id')
                                            ->label('Section')
                                            ->helperText(__('Секция в которой будет находится этот атрибут'))
                                            ->relationship(name: 'showSection', modifyQueryUsing: fn (Builder $query) => $query->orderBy('order_number'))
                                            ->getOptionLabelFromRecordUsing(fn (AttributeSection $record) => "#{$record->order_number} - {$record->name} ({$record->slug})")
                                            ->columnSpanFull()
                                            ->required()
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
                                                            ->rules([
                                                                fn (): Closure => function (string $attribute, $value, Closure $fail) {
                                                                    if (!isset($value['en']) OR $value['en'] == '') 
                                                                        $fail('The :attribute must contain english translation.');
                                                                },
                                                            ])
                                                            ->required()
                                                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state['en']))),

                                                        TextInput::make('slug')
                                                            ->required(),

                                                        TextInput::make('order_number')
                                                            ->helperText(__('Порядковый номер секции внутри формы.'))
                                                            ->numeric()
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
                                                            ->rules([
                                                                fn (): Closure => function (string $attribute, $value, Closure $fail) {
                                                                    if (!isset($value['en']) OR $value['en'] == '') 
                                                                        $fail('The :attribute must contain english translation.');
                                                                },
                                                            ])
                                                            ->required()
                                                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state['en']))),

                                                        TextInput::make('slug')
                                                            ->required(),

                                                        TextInput::make('order_number')
                                                            ->helperText(__('Порядковый номер секции внутри формы.'))
                                                            ->numeric()
                                                            ->required(),
                                                    ])
                                                    ->columns(2)
                                            ]),

                                        TextInput::make('show_layout.order_number')
                                            ->helperText(__("Порядковый номер этого атрибута внутри секции"))
                                            ->required(),
                                    ])
                                    ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),
                            ])
                            ->columns(3),

                        Section::make(__("Group"))
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Select::make('group_layout.group_id')
                                            ->label('Group')
                                            ->helperText(__('Группа в которой будет находится этот атрибут'))
                                            ->relationship(name: 'group')
                                            ->getOptionLabelFromRecordUsing(fn (AttributeGroup $record) => "#{$record->slug}")
                                            ->columnSpanFull()
                                            ->createOptionForm([
                                                Section::make()
                                                    ->schema([
                                                        TextInput::make('slug')
                                                            ->required(),

                                                        TextInput::make('separator')
                                                            ->helperText(__('Разделитель внутри группы.')),
                                                    ])
                                                    ->columns(2),
                                            ])
                                            ->editOptionForm([
                                                Section::make()
                                                    ->schema([
                                                        TextInput::make('slug')
                                                            ->required(),

                                                        TextInput::make('separator')
                                                            ->helperText(__('Разделитель внутри группы.')),
                                                    ])
                                                    ->columns(2)
                                            ]),

                                        TextInput::make('group_layout.order_number')
                                            ->helperText(__("Порядковый номер этого атрибута внутри группы"))
                                            ->requiredWith('group_layout.group_id'),
                                    ])
                                    ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),
                            ])
                            ->columns(3),

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
                                            ])
                                            ->rules([
                                                fn (): Closure => function (string $attribute, $value, Closure $fail) {
                                                    if (!isset($value['en']) OR $value['en'] == '') 
                                                        $fail('The :attribute must contain english translation.');
                                                },
                                            ])
                                            ->live(debounce: 500),

                                        Toggle::make('is_default')
                                            ->fixIndistinctState()
                                            ->helperText(__('Опция будет выбрана по умолчанию при создании объявления и при фильтрации.'))
                                            ->visible(fn (Get $get) => in_array($get('../../create_type'), [
                                                'toggle_buttons',
                                            ])),

                                        Toggle::make('is_null')
                                            ->helperText(__('Опция не будет отображаться при создании объявления и не будет учавствовать в фильтрации объявлений.'))
                                            ->live()
                                            ->visible(fn (Get $get) => in_array($get('../../create_type'), [
                                                'toggle_buttons',
                                            ])),
                                    ])
                                    ->relationship()
                                    ->reorderable()
                                    ->reorderableWithButtons()
                                    ->reorderableWithDragAndDrop(false)
                                    ->cloneable()
                                    ->itemLabel(fn (array $state): ?string => 
                                        ($state['alternames'][app()->getLocale()] ?? $state['alternames']['en'] ?? null) . ($state['is_default'] ? ", DEFAULT" : "") . ($state['is_null'] ? ", NULL" : "")
                                    )
                                    ->collapsed()
                                    ->columnSpanFull()
                                    ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200'])
                            ])
                            ->visible(fn (Get $get) => 
                                in_array($get('filter_layout.type'), array_keys($this->type_options['fields_with_options'])) 
                                OR in_array($get('create_layout.type'), array_keys($this->type_options['fields_with_options']))
                            ),
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

                                                        return Attribute::whereHas('attribute_options')
                                                            ->whereHas('categories', fn ($query) => $query->whereIn('category_id', $categories ?? []))
                                                            ->get()
                                                            ->pluck('label', 'name');
                                                    })
                                                    ->required()
                                                    ->live(),

                                                Select::make('value')
                                                    ->options(fn (Get $get) => Attribute::whereName($get('attribute_name'))->first()?->attribute_options->pluck('name', 'id'))
                                            ])
                                            ->visible(fn (Get $get) => $get('show_on_condition'))
                                            ->defaultItems(1)
                                            ->hiddenLabel()
                                            ->columns(1)
                                    ])
                                    ->columnSpan(1)
                                    ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),
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
                                                        $categories = Category::whereIn('id', $get('../../categories'))->get()->map(function ($category) { 
                                                            return $category->getParentsAndSelf()->pluck('id'); 
                                                        })
                                                        ->flatten();

                                                        return Attribute::whereHas('attribute_options')
                                                            ->whereHas('categories', fn ($query) => $query->whereIn('category_id', $categories ?? []))
                                                            ->get()
                                                            ->pluck('label', 'name');
                                                    })
                                                    ->required()
                                                    ->live(),

                                                Select::make('value')
                                                    ->options(fn (Get $get) => Attribute::whereName($get('attribute_name'))->first()?->attribute_options->pluck('name', 'id'))
                                            ])
                                            ->visible(fn (Get $get) => $get('hide_on_condition'))
                                            ->defaultItems(1)
                                            ->hiddenLabel()
                                            ->columns(1)
                                    ])
                                    ->columnSpan(1)
                                    ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200'])
                            ])
                            ->columns(2),
                    ])
                    ->slideOver()
                    ->extraModalWindowAttributes(['style' => 'background-color: #e5e7eb'])
                    ->closeModalByClickingAway(false),
                
            ])
            ->actions([
                // ActionGroup::make([
                    EditAction::make('Edit')
                        ->modalHeading(fn ($record) => $record->label)
                        ->modalDescription(fn ($record) => $record->name)
                        ->form([
                            Section::make(__('Categories'))
                                ->schema([
                                    Grid::make(2)
                                        ->schema([
                                            Select::make('categories')
                                                ->helperText("Категории к которым принадлежит атрибут. (можно выбрать несколько)")
                                                ->relationship('categories')
                                                ->multiple()
                                                ->options($this->categories)
                                                ->columnSpanFull(),
                                        ])
                                        ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),
                                ]),
                                
                            Section::make(__('Name'))
                                ->schema([
                                    Grid::make(2)
                                        ->schema([
                                            KeyValue::make('alterlabels')
                                                ->label(__('Label'))
                                                ->helperText("Лейбел атрибута. Будет виден пользователю в виде названия поля.")
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
                                                ->afterStateUpdated(fn ($state, Set $set) => $set('name', str()->snake($state['en'])))
                                                ->rules([
                                                    fn (): Closure => function (string $attribute, $value, Closure $fail) {
                                                        if (!isset($value['en']) OR $value['en'] == '') 
                                                            $fail('The :attribute must contain english translation.');
                                                    },
                                                ]),

                                            TextInput::make('name')
                                                ->label(__('Slug'))
                                                ->required()
                                                ->columnSpanFull()
                                                ->unique(ignoreRecord: true),
                                        ])
                                        ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),

                                    Grid::make(2)
                                        ->schema([
                                            Toggle::make('has_suffix')
                                                ->label(__('Has suffix'))
                                                ->live()
                                                ->dehydrated(false)
                                                ->default(false)
                                                ->columnSpanFull()
                                                ->afterStateUpdated(fn (Attribute $attribute, Set $set, $state) => 
                                                    $set('altersuffixes', $state 
                                                        ? (!empty($attribute->altersuffixes ?? []) ? $attribute->altersuffixes : [
                                                            'en' => '',
                                                            'cs' => '',
                                                            'ru' => '',
                                                        ])
                                                        : null)
                                                ),

                                            KeyValue::make('altersuffixes')
                                                ->label(__('Suffix'))
                                                ->keyLabel(__('Language'))
                                                ->valueLabel(__('Value'))
                                                ->rules([
                                                    fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                                        if ($get('has_suffix') AND (!isset($value['en']) OR $value['en'] === '')) 
                                                            $fail('The :attribute must contain english translation.');
                                                    },
                                                ])
                                                ->dehydratedWhenHidden('true')
                                                ->afterStateHydrated(fn ($state, Set $set) => $set('has_suffix', !empty(array_filter($state ?? []))))
                                                ->visible(fn (Get $get) => $get('has_suffix')),
                                        ])
                                        ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),
                                ])
                                ->columns(2),

                            Section::make(__("Create layout"))
                                ->schema([
                                    Grid::make(3)
                                        ->schema([
                                            Select::make('create_layout.type')
                                                ->options($this->type_options)
                                                ->required()
                                                ->helperText("Тип атрибута при создании объявления.")
                                                ->afterStateUpdated(function (Get $get, Set $set, $state) { 
                                                    !$get('filter_layout.type')
                                                        ? $set('filter_layout.type', $state) 
                                                        : null;
                                                    $set('show_layout.type', $state);
                                                })
                                                ->afterStateHydrated(fn ($state, Set $set) => $set('show_layout.type', $state))
                                                ->columnSpanFull()
                                                ->live(),
                                            
                                            Select::make('create_layout.rules')
                                                ->label('Validation rulles')
                                                ->multiple()
                                                ->required()
                                                ->columnSpanFull()
                                                ->options($this->validation_rules)
                                                ->visible(fn (Get $get) => in_array($get('create_layout.type'), array_keys($this->type_options['text_fields']))),
                                        ])
                                        ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),
                                    
                                    Grid::make(3)  
                                        ->schema([
                                            Select::make('create_layout.section_id')
                                                ->label('Section')
                                                ->helperText(__('Секция в которой будет находится этот атрибут'))
                                                ->relationship(name: 'createSection', modifyQueryUsing: fn (Builder $query) => $query->orderBy('order_number'))
                                                ->getOptionLabelFromRecordUsing(fn (AttributeSection $record) => "#{$record->order_number} - {$record->name} ({$record->slug})")
                                                ->columnSpanFull()
                                                ->required()
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
                                                                ->rules([
                                                                    fn (): Closure => function (string $attribute, $value, Closure $fail) {
                                                                        if (!isset($value['en']) OR $value['en'] == '') 
                                                                            $fail('The :attribute must contain english translation.');
                                                                    },
                                                                ])
                                                                ->required()
                                                                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state['en']))),

                                                            TextInput::make('slug')
                                                                ->required(),

                                                            TextInput::make('order_number')
                                                                ->helperText(__('Порядковый номер секции внутри формы.'))
                                                                ->numeric()
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
                                                                ->rules([
                                                                    fn (): Closure => function (string $attribute, $value, Closure $fail) {
                                                                        if (!isset($value['en']) OR $value['en'] == '') 
                                                                            $fail('The :attribute must contain english translation.');
                                                                    },
                                                                ])
                                                                ->required()
                                                                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state['en']))),

                                                            TextInput::make('slug')
                                                                ->required(),

                                                            TextInput::make('order_number')
                                                                ->helperText(__('Порядковый номер секции внутри формы.'))
                                                                ->numeric()
                                                                ->required(),
                                                        ])
                                                        ->columns(2)
                                                ])
                                                ->afterStateUpdated(fn (Get $get, Set $set) => 
                                                    !$get('filter_layout.section_id')
                                                        ? $set('filter_layout.section_id', $get('create_layout.section_id')) 
                                                        : null
                                                )
                                                ->live(),

                                            TextInput::make('create_layout.column_span')
                                                ->helperText(__("Сколько места по ширине, внутри секции, будет занимать этот атрибут (от 1 до 4)"))
                                                ->afterStateUpdated(fn (Get $get, Set $set) => 
                                                    !$get('filter_layout.column_span')
                                                        ? $set('filter_layout.column_span', $get('create_layout.column_span')) 
                                                        : null
                                                )
                                                ->live()
                                                ->required(),

                                            TextInput::make('create_layout.column_start')
                                                ->helperText(__("В каком месте в линии будет находиться этот атрибут в секции (от 1 до 4)"))
                                                ->afterStateUpdated(fn (Get $get, Set $set) => 
                                                    !$get('filter_layout.column_start')
                                                        ? $set('filter_layout.column_start', $get('create_layout.column_start')) 
                                                        : null
                                                )
                                                ->live()
                                                ->required(),

                                            TextInput::make('create_layout.order_number')
                                                ->helperText(__("Порядковый номер этого атрибута внутри секции"))
                                                ->afterStateUpdated(fn (Get $get, Set $set) => 
                                                    !$get('filter_layout.order_number')
                                                        ? $set('filter_layout.order_number', $get('create_layout.order_number')) 
                                                        : null
                                                )
                                                ->live()
                                                ->required(),
                                        ])
                                        ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),
                                    
                                    Grid::make(3)
                                        ->schema([
                                            Toggle::make('is_feature')
                                                ->helperText(__("Является ли этот атрибут характеристикой")),

                                            Toggle::make('translatable')
                                                ->helperText(__("Будет ли переводится этот атрибут автоматически"))
                                                ->visible(fn (Get $get) => in_array($get('create_layout.type'), array_keys($this->type_options['text_fields']))),

                                            Toggle::make('required')
                                                ->helperText(__("Является ли этот атрибут обязательным при создании объявления")),
                                        ])
                                        ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),

                                ])
                                ->columns(3),

                            Section::make(__("Filter layout"))
                                ->schema([
                                    Grid::make(3)
                                        ->schema([
                                            Select::make('filter_layout.type')
                                                ->options($this->type_options)
                                                ->required()
                                                ->helperText("Тип атрибута при поиске.")
                                                ->columnSpanFull()
                                                ->live(),
                                        ])
                                        ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),

                                    Grid::make(3)
                                        ->schema([
                                            Select::make('filter_layout.section_id')
                                                ->label('Section')
                                                ->helperText(__('Секция в которой будет находится этот атрибут'))
                                                ->relationship(name: 'filterSection', modifyQueryUsing: fn (Builder $query) => $query->orderBy('order_number'))
                                                ->getOptionLabelFromRecordUsing(fn (AttributeSection $record) => "#{$record->order_number} - {$record->name} ({$record->slug})")
                                                ->columnSpanFull()
                                                ->required()
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
                                                                ->rules([
                                                                    fn (): Closure => function (string $attribute, $value, Closure $fail) {
                                                                        if (!isset($value['en']) OR $value['en'] == '') 
                                                                            $fail('The :attribute must contain english translation.');
                                                                    },
                                                                ])
                                                                ->required()
                                                                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state['en']))),

                                                            TextInput::make('slug')
                                                                ->required(),

                                                            TextInput::make('order_number')
                                                                ->helperText(__('Порядковый номер секции внутри формы.'))
                                                                ->numeric()
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
                                                                ->rules([
                                                                    fn (): Closure => function (string $attribute, $value, Closure $fail) {
                                                                        if (!isset($value['en']) OR $value['en'] == '') 
                                                                            $fail('The :attribute must contain english translation.');
                                                                    },
                                                                ])
                                                                ->required()
                                                                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state['en']))),

                                                            TextInput::make('slug')
                                                                ->required(),

                                                            TextInput::make('order_number')
                                                                ->helperText(__('Порядковый номер секции внутри формы.'))
                                                                ->numeric()
                                                                ->required(),
                                                        ])
                                                        ->columns(2)
                                                ]),
                                            TextInput::make('filter_layout.column_span')
                                                ->helperText(__("Сколько места по ширине, внутри секции, будет занимать этот атрибут (от 1 до 4)"))
                                                ->required(),

                                            TextInput::make('filter_layout.column_start')
                                                ->helperText(__("В каком месте (слева или справа) будет находиться этот атрибут в секции (от 1 до 4)"))
                                                ->required(),

                                            TextInput::make('filter_layout.order_number')
                                                ->helperText(__("Порядковый номер этого атрибута внутри секции"))
                                                ->required()
                                        ])
                                        ->hidden(fn (Get $get) => $get('filter_layout.type') == 'hidden')
                                        ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),

                                    Grid::make(3)
                                        ->schema([
                                            Toggle::make('is_sortable')
                                                ->helperText(__("Является ли этот атрибут для сортировки")),
                                        ])
                                        ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),
                                ])
                                ->columns(3),

                            Section::make(__("Show layout"))
                                ->schema([
                                    Grid::make(3)
                                        ->schema([
                                            Select::make('show_layout.type')
                                                ->options($this->type_options)
                                                ->required()
                                                ->live(),
                                        ])
                                        ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),

                                    Grid::make(3)
                                        ->schema([
                                            Select::make('show_layout.section_id')
                                                ->label('Section')
                                                ->helperText(__('Секция в которой будет находится этот атрибут'))
                                                ->relationship(name: 'showSection', modifyQueryUsing: fn (Builder $query) => $query->orderBy('order_number'))
                                                ->getOptionLabelFromRecordUsing(fn (AttributeSection $record) => "#{$record->order_number} - {$record->name} ({$record->slug})")
                                                ->columnSpanFull()
                                                ->required()
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
                                                                ->rules([
                                                                    fn (): Closure => function (string $attribute, $value, Closure $fail) {
                                                                        if (!isset($value['en']) OR $value['en'] == '') 
                                                                            $fail('The :attribute must contain english translation.');
                                                                    },
                                                                ])
                                                                ->required()
                                                                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state['en']))),

                                                            TextInput::make('slug')
                                                                ->required(),

                                                            TextInput::make('order_number')
                                                                ->helperText(__('Порядковый номер секции внутри формы.'))
                                                                ->numeric()
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
                                                                ->rules([
                                                                    fn (): Closure => function (string $attribute, $value, Closure $fail) {
                                                                        if (!isset($value['en']) OR $value['en'] == '') 
                                                                            $fail('The :attribute must contain english translation.');
                                                                    },
                                                                ])
                                                                ->required()
                                                                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state['en']))),

                                                            TextInput::make('slug')
                                                                ->required(),

                                                            TextInput::make('order_number')
                                                                ->helperText(__('Порядковый номер секции внутри формы.'))
                                                                ->numeric()
                                                                ->required(),
                                                        ])
                                                        ->columns(2)
                                                ]),

                                            TextInput::make('show_layout.order_number')
                                                ->helperText(__("Порядковый номер этого атрибута внутри секции"))
                                                ->required(),
                                        ])
                                        ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),
                                ])
                                ->columns(3),

                            Section::make(__("Group"))
                                ->schema([
                                    Grid::make(3)
                                        ->schema([
                                            Select::make('group_layout.group_id')
                                                ->label('Group')
                                                ->helperText(__('Группа в которой будет находится этот атрибут'))
                                                ->relationship(name: 'group')
                                                ->getOptionLabelFromRecordUsing(fn (AttributeGroup $record) => "#{$record->slug}")
                                                ->columnSpanFull()
                                                ->createOptionForm([
                                                    Section::make()
                                                        ->schema([
                                                            TextInput::make('slug')
                                                                ->required(),

                                                            TextInput::make('separator')
                                                                ->helperText(__('Разделитель внутри группы.')),
                                                        ])
                                                        ->columns(2),
                                                ])
                                                ->editOptionForm([
                                                    Section::make()
                                                        ->schema([
                                                            TextInput::make('slug')
                                                                ->required(),

                                                            TextInput::make('separator')
                                                                ->helperText(__('Разделитель внутри группы.')),
                                                        ])
                                                        ->columns(2)
                                                ]),

                                            TextInput::make('group_layout.order_number')
                                                ->helperText(__("Порядковый номер этого атрибута внутри группы"))
                                                ->requiredWith('group_layout.group_id'),
                                        ])
                                        ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),
                                ])
                                ->columns(3),

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
                                                ])
                                                ->rules([
                                                    fn (): Closure => function (string $attribute, $value, Closure $fail) {
                                                        if (!isset($value['en']) OR $value['en'] == '') 
                                                            $fail('The :attribute must contain english translation.');
                                                    },
                                                ])
                                                ->live(debounce: 500),

                                            Toggle::make('is_default')
                                                ->fixIndistinctState()
                                                ->helperText(__('Опция будет выбрана по умолчанию при создании объявления и при фильтрации.'))
                                                ->visible(fn (Get $get) => in_array($get('../../create_type'), [
                                                    'toggle_buttons',
                                                ])),

                                            Toggle::make('is_null')
                                                ->helperText(__('Опция не будет отображаться при создании объявления и не будет учавствовать в фильтрации объявлений.'))
                                                ->live()
                                                ->visible(fn (Get $get) => in_array($get('../../create_type'), [
                                                    'toggle_buttons',
                                                ])),
                                        ])
                                        ->relationship()
                                        ->reorderable()
                                        ->reorderableWithButtons()
                                        ->reorderableWithDragAndDrop(false)
                                        ->cloneable()
                                        ->itemLabel(fn (array $state): ?string => 
                                            ($state['alternames'][app()->getLocale()] ?? $state['alternames']['en'] ?? null) . ($state['is_default'] ? ", DEFAULT" : "") . ($state['is_null'] ? ", NULL" : "")
                                        )
                                        ->collapsed()
                                        ->columnSpanFull()
                                        ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200'])
                                ])
                                ->visible(fn (Get $get) => 
                                    in_array($get('filter_layout.type'), array_keys($this->type_options['fields_with_options'])) 
                                    OR in_array($get('create_layout.type'), array_keys($this->type_options['fields_with_options']))
                                ),

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

                                                            return Attribute::whereHas('attribute_options')
                                                                ->whereHas('categories', fn ($query) => $query->whereIn('category_id', $categories ?? []))
                                                                ->get()
                                                                ->pluck('label', 'name');
                                                        })
                                                        ->required()
                                                        ->live(),

                                                    Select::make('value')
                                                        ->options(fn (Get $get) => Attribute::whereName($get('attribute_name'))->first()?->attribute_options->pluck('name', 'id'))
                                                ])
                                                ->visible(fn (Get $get) => $get('show_on_condition'))
                                                ->afterStateHydrated(fn ($state, Set $set) => $set('show_on_condition', !empty($state)))
                                                ->defaultItems(1)
                                                ->hiddenLabel()
                                                ->columns(1)
                                        ])
                                        ->columnSpan(1)
                                        ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),
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

                                                            return Attribute::whereHas('attribute_options')
                                                                ->whereHas('categories', fn ($query) => $query->whereIn('category_id', $categories ?? []))
                                                                ->get()
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
                                        ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200'])
                                ])
                                ->columns(2),
                        ])
                        ->hiddenLabel()
                        ->button()
                        ->slideOver()
                        ->extraModalWindowAttributes(['style' => 'background-color: #e5e7eb'])
                        ->closeModalByClickingAway(false),
                    DeleteAction::make()
                        ->hiddenLabel()
                        ->button()
                // ])
            ])
            ->paginated(false)
            ->filters([
                SelectFilter::make('category')
                    ->options($this->categories)
                    ->query(fn ($query, $data) => 
                        $query->when($data['value'], fn ($query) => $query->whereHas('categories', fn ($query) => $query->where('category_id', $data['value'])))
                    )
            ]);
    }
}
