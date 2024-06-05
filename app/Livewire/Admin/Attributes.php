<?php

namespace App\Livewire\Admin;

use App\Models\Attribute;
use App\Models\Category;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
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
            ->heading("All attributes")
            ->query(Attribute::query())
            ->groups([
                Group::make('section.slug')
                    ->getTitleFromRecordUsing(fn (Attribute $attribute): string => $attribute->section->slug . " " . $attribute->section->order_number),
            ])
            ->defaultSort('order_number')
            ->defaultGroup('section.slug')
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order')
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
                TextColumn::make('attribute_options.name')->badge()
                    ->grow(false),
                ToggleColumn::make('searchable')
                    ->grow(false),
                ToggleColumn::make('filterable')
                    ->grow(false),
                ToggleColumn::make('is_feature')->disabled()
                    ->grow(false)
            ])
            ->headerActions([
                CreateAction::make()
                    ->model(Attribute::class)
                    ->icon('heroicon-o-plus-circle')
                    ->form([
                        Section::make()
                            ->schema([
                                Select::make('categories')
                                    ->relationship('categories')
                                    ->multiple()
                                    ->options(Category::all()->groupBy('parent.name')->map->pluck('name', 'id')),
                                KeyValue::make('alterlabels')
                                    ->label('Label')
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
                                    ->required(),
                                KeyValue::make('altersyffixes')
                                    ->label('Suffix')
                                    ->default([
                                        'en' => '',
                                        'cs' => '',
                                        'ru' => '',
                                    ]),
                            ])
                            ->columns(2),

                        Section::make()
                            ->schema([
                                Select::make('create_type')
                                    ->options($this->type_options)
                                    ->required()
                                    ->live(),
                                Select::make('search_type')
                                    ->options($this->type_options)
                                    ->required(),
                                Toggle::make('translatable'),
                                Toggle::make('is_feature'),
                                Toggle::make('required'),
                                Toggle::make('searchable'),
                                Toggle::make('filterable'),
                                Toggle::make('always_required'),
                                Select::make('rules')
                                    ->label('Validation rulles')
                                    ->multiple()
                                    ->columnSpanFull()
                                    ->options($this->validation_rules)
                            ])
                            ->columns(2),

                        Repeater::make('attribute_options')
                            ->hiddenLabel()
                            ->schema([
                                KeyValue::make('alternames')
                                    ->default([
                                        'en' => '',
                                        'cs' => '',
                                        'ru' => '',
                                    ]),
                                Toggle::make('is_default'),
                                Toggle::make('is_null'),
                            ])
                            ->relationship()
                            ->hidden(fn (Get $get) => $get('create_type') != 'select' AND $get('create_type') != 'toggle_buttons')
                            ->reorderableWithButtons()
                            ->reorderableWithDragAndDrop(false)
                            ->cloneable()
                            ->columnSpanFull(),
                        
                        Section::make()
                            ->schema([
                                Select::make('attribute_section_id')
                                    ->label('Section')
                                    ->relationship(name: 'section', titleAttribute: 'slug')
                                    ->createOptionForm([
                                        Section::make()
                                            ->schema([
                                                KeyValue::make('alternames')
                                                    ->label('Label')
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
                            ]),

                        Section::make()
                            ->schema([
                                TextInput::make('column_span')
                                    ->required(),
                                TextInput::make('column_start')
                                    ->required(),
                                TextInput::make('order_number')
                                    ->required(),
                            ])
                            ->columns(3),

                        Repeater::make('visible')
                            ->schema([
                                Select::make('attribute_name')
                                    ->label('Attribute')
                                    ->options(Attribute::with('section')->get()->groupBy('section.slug')->map->pluck('label', 'name'))
                                    ->required()
                                    ->live(),
                                Select::make('value')
                                    ->options(fn (Get $get) => Attribute::whereName($get('attribute_name'))->first()?->attribute_options->pluck('name', 'id'))
                            ])
                            ->columns(2)
                    ])
                    ->slideOver()
                    ->closeModalByClickingAway(false),
                
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->form([
                                Section::make()
                                    ->schema([
                                        Select::make('categories')
                                            ->relationship('categories')
                                            ->multiple()
                                            ->options(Category::all()->groupBy('parent.name')->map->pluck('name', 'id')),
                                        KeyValue::make('alterlabels')
                                            ->label('Label')
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
                                            ->required(),
                                        KeyValue::make('altersyffixes')
                                            ->label('Suffix')
                                            ->default([
                                                'en' => '',
                                                'cs' => '',
                                                'ru' => '',
                                            ]),
                                    ])
                                    ->columns(2),

                                Section::make()
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
                                        Select::make('rules')
                                            ->label('Validation rulles')
                                            ->multiple()
                                            ->columnSpanFull()
                                            ->options($this->validation_rules)
                                    ])
                                    ->columns(2),

                                Repeater::make('attribute_options')
                                    ->hiddenLabel()
                                    ->schema([
                                        KeyValue::make('alternames')
                                            ->default([
                                                'en' => '',
                                                'cs' => '',
                                                'ru' => '',
                                            ]),
                                        Toggle::make('is_default')
                                            ->fixIndistinctState()
                                            ->live(),
                                        Toggle::make('is_null'),
                                    ])
                                    ->relationship()
                                    ->hidden(fn (Get $get) => $get('create_type') != 'select' AND $get('create_type') != 'toggle_buttons')
                                    ->reorderableWithButtons()
                                    ->reorderableWithDragAndDrop(false)
                                    ->cloneable()
                                    ->columnSpanFull(),

                                Section::make()
                                    ->schema([
                                        Select::make('attribute_section_id')
                                            ->label('Section')
                                            ->relationship(name: 'section', titleAttribute: 'slug')
                                            ->createOptionForm([
                                                Section::make()
                                                    ->schema([
                                                        KeyValue::make('alternames')
                                                            ->label('Label')
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
                                    ]),

                                Section::make()
                                    ->schema([
                                        TextInput::make('column_span')
                                            ->required(),
                                        TextInput::make('column_start')
                                            ->required(),
                                        TextInput::make('order_number')
                                            ->required(),
                                    ])
                                    ->columns(3),

                                Repeater::make('visible')
                                    ->schema([
                                        Select::make('attribute_name')
                                            ->label('Attribute')
                                            ->options(Attribute::with('section')->get()->groupBy('section.slug')->map->pluck('label', 'name')->toArray())
                                            ->required()
                                            ->live(),
                                        Select::make('value')
                                            ->options(fn (Get $get) => Attribute::whereName($get('attribute_name'))->first()?->attribute_options->pluck('name', 'id'))
                                    ])
                                    ->columns(2)
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
