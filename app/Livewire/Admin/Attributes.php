<?php

namespace App\Livewire\Admin;

use App\Jobs\CreateSeedersJob;
use App\Models\Attribute;
use App\Models\Category;
use Closure;
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
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class Attributes extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    #[Layout('layouts.admin')]

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
        ],
        'text_fields' => [
            'price' => 'Цена',
            'price_from' => 'Цена от',
            'text_input' => 'Текстовое поле',
            'search' => 'Поиск',
            'search_in_description' => 'Поиск в описании',
            'text_area' => 'Текстовый блок',
            'between'   => 'Между',
            'from'  => 'От',
            'markdown_editor' => 'Markdown Editor',
        ],
        'other' => [
            'toggle'    => 'Переключатель',
            'location'  => 'Местоположение',
            'hidden'    => 'Скрытое поле',
        ]
    ];
    
    public function table(Table $table): Table
    {
        return $table
            ->heading("All attributes: " . Attribute::count())
            ->query(Attribute::with('attribute_options'))
            ->groups([
                Group::make('section.slug')
                    ->getTitleFromRecordUsing(fn (Attribute $attribute): string => $attribute?->section?->name ?? 'null')
                    ->getDescriptionFromRecordUsing(fn (Attribute $attribute): string => $attribute?->section?->slug  . ", order: " . $attribute?->section?->order_number)
                    ->titlePrefixedWithLabel(false)
                    ->collapsible(),
                Group::make('create_type')
                    ->getTitleFromRecordUsing(fn (Attribute $attribute): string => $this->getTypeOprions()[$attribute?->create_type])
                    ->titlePrefixedWithLabel(false)
                    ->collapsible(),
                Group::make('search_type')
                    ->getTitleFromRecordUsing(fn (Attribute $attribute): string => $this->getTypeOprions()[$attribute?->search_type])
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
                    ->description(fn (Attribute $attribute): string =>  $attribute?->name . ($attribute?->suffix ? " ({$attribute?->suffix})" : '')),
                SelectColumn::make('create_type')
                    ->grow(false)
                    ->options($this->getTypeOprions())
                    ->selectablePlaceholder(false),
                SelectColumn::make('search_type')
                    ->grow(false)
                    ->options($this->getTypeOprions())
                    ->selectablePlaceholder(false),
                TextColumn::make('attribute_options')
                    ->state(fn (Attribute $record) => $record->attribute_options->pluck('name'))
                    ->badge()
                    ->grow(false),
                // ToggleColumn::make('searchable')
                //     ->grow(false),
                // ToggleColumn::make('filterable')
                //     ->grow(false),
                // ToggleColumn::make('is_feature')->disabled()
                //     ->grow(false)
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
                                Select::make('categories')
                                    ->helperText("Категории к которым принадлежит атрибут. (можно выбрать несколько)")
                                    ->hiddenLabel()
                                    ->relationship('categories')
                                    ->multiple()
                                    ->options(Category::with('parent')->get()->groupBy('parent.name')->map->pluck('name', 'id')),
                            ]),

                        Section::make(__('Name'))
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
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('name', str()->snake($state['en'])))
                                    ->rules([
                                        fn (): Closure => function (string $attribute, $value, Closure $fail) {
                                            if (!isset($value['en']) OR $value['en'] == '') 
                                                $fail('The :attribute must contain english translation.');
                                        },
                                    ]),
                                TextInput::make('name')
                                    ->label(__('Name'))
                                    ->required()
                                    ->columnSpanFull(),
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
                            ->columns(2),

                        Section::make(__('Types'))
                            ->schema([
                                Select::make('create_type')
                                    ->options($this->type_options)
                                    ->live()
                                    ->required()
                                    ->helperText("Тип атрибута при создании объявления."),
                                Select::make('search_type')
                                    ->options($this->type_options)
                                    ->required()
                                    ->helperText("Тип атрибута при поиске."),
                                Toggle::make('translatable')
                                    ->helperText(__("Будет ли переводится этот атрибут автоматически"))
                                    ->visible(fn (Get $get) => in_array($get('create_type'), array_keys($this->type_options['text_fields']))),
                                Toggle::make('is_feature')
                                    ->helperText(__("Является ли этот атрибут характеристикой")),
                                Toggle::make('required')
                                    ->helperText(__("Является ли этот атрибут обязательным при создании объявления")),
                                Toggle::make('searchable')
                                    ->helperText(__("Будет ли атрибут показываться в карточке объявления при поиске")),
                                Toggle::make('filterable')
                                    ->helperText(__("Можно ли фильтровать по этому атрибуту")),
                                Toggle::make('always_required')
                                    ->helperText(__("Будет ли этот атрибут всегда обязательным и показываться вне зависимости от фильтрации. (Относится к меньшему числу атрибутов, таких как цена, заголовок и т.д.)")),
                                Select::make('rules')
                                    ->label('Validation rulles')
                                    ->multiple()
                                    ->columnSpanFull()
                                    ->options($this->validation_rules)
                                    ->visible(fn (Get $get) => in_array($get('create_type'), array_keys($this->type_options['text_fields']))),
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
                                    ->itemLabel(fn (array $state): ?string => ($state['alternames'][app()->getLocale()] ?? null) . ($state['is_default'] == true ? ", DEFAULT" : "") . ($state['is_null'] == true ? ", NULL" : ""))
                                    ->collapsed()
                                    ->columnSpanFull()
                            ])
                            ->visible(fn (Get $get) => in_array($get('create_type'), array_keys($this->type_options['fields_with_options']))),

                        Section::make(__("Layout"))
                            ->schema([
                                Select::make('attribute_section_id')
                                    ->label('Section')
                                    ->helperText(__('Секция в которой будет находится этот атрибут'))
                                    ->relationship(name: 'section', titleAttribute: 'slug')
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
                                TextInput::make('column_span')
                                    ->helperText(__("Сколько места по ширине, внутри секции, будет занимать этот атрибут (от 1 до 2)"))
                                    ->required(),
                                TextInput::make('column_start')
                                    ->helperText(__("В каком месте (слева или справа) будет находиться этот атрибут в секции (от 1 до 2)"))
                                    ->required(),
                                TextInput::make('order_number')
                                    ->helperText(__("Порядковый номер этого атрибута внутри секции"))
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
                                                        $categories = Category::whereIn('id', $get('../../categories'))->get()->map(function ($category) { 
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
                                        ->helperText("Категории к которым принадлежит атрибут. (можно выбрать несколько)")
                                        ->hiddenLabel()
                                        ->relationship('categories')
                                        ->multiple()
                                        ->options(Category::with('parent')->get()->groupBy('parent.name')->map->pluck('name', 'id')),
                                ]),
                                
                            Section::make(__('Name'))
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
                                        ->label(__('Name'))
                                        ->required()
                                        ->columnSpanFull(),
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
                                ->columns(2),

                            Section::make(__('Types'))
                                ->schema([
                                    Select::make('create_type')
                                        ->options($this->type_options)
                                        ->live()
                                        ->required()
                                        ->helperText("Тип атрибута при создании объявления."),
                                    Select::make('search_type')
                                        ->options($this->type_options)
                                        ->required()
                                        ->helperText("Тип атрибута при поиске."),
                                    Toggle::make('translatable')
                                        ->helperText(__("Будет ли переводится этот атрибут автоматически"))
                                        ->visible(fn (Get $get) => in_array($get('create_type'), array_keys($this->type_options['text_fields']))),
                                    Toggle::make('is_feature')
                                        ->helperText(__("Является ли этот атрибут характеристикой")),
                                    Toggle::make('required')
                                        ->helperText(__("Является ли этот атрибут обязательным при создании объявления")),
                                    Toggle::make('searchable')
                                        ->helperText(__("Будет ли атрибут показываться в карточке объявления при поиске")),
                                    Toggle::make('filterable')
                                        ->helperText(__("Можно ли фильтровать по этому атрибуту")),
                                    Toggle::make('always_required')
                                        ->helperText(__("Будет ли этот атрибут всегда обязательным и показываться вне зависимости от категории. (Относится к меньшему числу атрибутов, таких как цена, заголовок и т.д.)")),
                                    Select::make('rules')
                                        ->label('Validation rulles')
                                        ->multiple()
                                        ->columnSpanFull()
                                        ->options($this->validation_rules)
                                        ->visible(fn (Get $get) => in_array($get('create_type'), array_keys($this->type_options['text_fields']))),
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
                                        ->itemLabel(fn (array $state): ?string => ($state['alternames'][app()->getLocale()] ?? null) . ($state['is_default'] ? ", DEFAULT" : "") . ($state['is_null'] ? ", NULL" : ""))
                                        ->collapsed()
                                        ->columnSpanFull()
                                ])
                                ->visible(fn (Get $get) => in_array($get('create_type'), array_keys($this->type_options['fields_with_options']))),

                            Section::make(__("Layout"))
                                ->schema([
                                    Select::make('attribute_section_id')
                                        ->label('Section')
                                        ->helperText(__('Секция в которой будет находится этот атрибут'))
                                        ->relationship(name: 'section', titleAttribute: 'slug')
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
                                    TextInput::make('column_span')
                                        ->helperText(__("Сколько места по ширине, внутри секции, будет занимать этот атрибут (от 1 до 2)"))
                                        ->required(),
                                    TextInput::make('column_start')
                                        ->helperText(__("В каком месте (слева или справа) будет находиться этот атрибут в секции (от 1 до 2)"))
                                        ->required(),
                                    TextInput::make('order_number')
                                        ->helperText(__("Порядковый номер этого атрибута внутри секции"))
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
            ->paginated(false)
            ->filters([
                SelectFilter::make('category')
                    ->options(fn () => 
                        Category::select('id', 'alternames', 'slug', 'parent_id')
                                ->with('parent')
                                ->get()
                                ->groupBy('parent.name')
                                ->map
                                ->pluck('name', 'id')
                    )
                    ->query(fn ($query, $data) => 
                        $query->when($data['value'], fn ($query) => $query->whereHas('categories', fn ($query) => $query->where('category_id', $data['value'])))
                    )
            ]);
    }
    public function render()
    {
        return view('livewire.admin.attributes');
    }

    private function getTypeOprions()
    {
        $keys = [];

        array_walk_recursive($this->type_options, function($value, $key) use (&$keys) {
            $keys[$key] = $value;
        });

        return $keys;
    }
}
