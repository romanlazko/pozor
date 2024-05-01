<?php

namespace App\Livewire\Admin;

use App\Models\Attribute;
use App\Models\AttributeSection;
use App\Models\Category;
use Filament\Forms\Components\Fieldset;
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
use Filament\Support\View\Components\Modal;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
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

    public $type_options = [
        'select' => 'Select',
        'text_input' => 'Text Input',
        'search' => 'Search',
        'text_area' => 'Text Area',
        'toggle_buttons' => 'Toggle Buttons',
        'toggle'    => 'Toggle',
        'between'   => 'Between',
        'checkboxlist'   => 'Checkbox List',
        'location'  => 'Location',
        'hidden'    => 'Hidden',
    ];
    
    public function table(Table $table): Table
    {
        return $table
            ->heading("All attributes")
            ->query(Attribute::query())
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order')
                    ->grow(false),
                TextColumn::make('label')
                    ->description(fn (Attribute $attribute): string => $attribute->name),
                // SelectColumn::make('create_type')
                //     ->options($this->type_options)
                //     ->selectablePlaceholder(false),
                // SelectColumn::make('search_type')
                //     ->options($this->type_options),
                TextColumn::make('attribute_options.name')->badge()
                    ->grow(false),
                ToggleColumn::make('required')
                    ->grow(false),
                ToggleColumn::make('searchable')
                    ->grow(false),
                ToggleColumn::make('translatable')->disabled()
                    ->grow(false),
                ToggleColumn::make('is_feature')->disabled()
                    ->grow(false)
            ])
            ->defaultGroup('section.slug')
            ->defaultSort('order_number')
            ->headerActions([
                CreateAction::make()
                    ->model(Attribute::class)
                    ->icon('heroicon-o-plus-circle')
                    ->form([
                        Section::make()
                            ->schema([
                                TextInput::make('label')
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('name', str()->snake($state))),
                                TextInput::make('name')
                                    ->required(),
                                KeyValue::make('alterlabels')
                                    ->columnSpan(2)
                                    ->default([
                                        'en' => '',
                                        'cz' => '',
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
                            ])
                            ->columns(2),

                        Repeater::make('attribute_options')
                            ->hiddenLabel()
                            ->schema([
                                TextInput::make('name')
                                    ->required(),
                                KeyValue::make('alternames')
                                    ->default([
                                        'en' => '',
                                        'cz' => '',
                                        'ru' => '',
                                    ]),
                            ])
                            ->relationship()
                            ->hidden(fn (Get $get) => $get('create_type') != 'select' AND $get('create_type') != 'toggle_buttons')
                            ->columns(2)
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
                                                TextInput::make('name')
                                                    ->live(debounce: 500)
                                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state))),
                                                TextInput::make('slug'),
                                                KeyValue::make('alternames')
                                                    ->columnSpan(2)
                                                    ->default([
                                                        'en' => '',
                                                        'cz' => '',
                                                        'ru' => '',
                                                    ]),
                                                TextInput::make('order_number')
                                                    ->required(),
                                                
                                            ])
                                            ->columns(2),
                                    ])
                                    ->editOptionForm([
                                        Section::make()
                                            ->schema([
                                                TextInput::make('name')
                                                    ->live(debounce: 500)
                                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state))),
                                                TextInput::make('slug'),
                                                KeyValue::make('alternames')
                                                    ->columnSpan(2)
                                                    ->default([
                                                        'en' => '',
                                                        'cz' => '',
                                                        'ru' => '',
                                                    ]),
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
                
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->form([
                                Section::make()
                                    ->schema([
                                        TextInput::make('label')
                                            ->live(debounce: 500)
                                            ->afterStateUpdated(fn ($state, callable $set) => $set('name', str()->snake($state))),
                                        TextInput::make('name')
                                            ->required(),
                                        KeyValue::make('alterlabels')
                                            ->columnSpan(2),
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
                                    ])
                                    ->columns(2),

                                Repeater::make('attribute_options')
                                    ->hiddenLabel()
                                    ->schema([
                                        TextInput::make('name')
                                            ->required(),
                                        KeyValue::make('alternames'),
                                    ])
                                    ->relationship()
                                    ->hidden(fn (Get $get) => $get('create_type') != 'select' AND $get('create_type') != 'toggle_buttons')
                                    ->columns(2)
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
                                                        TextInput::make('name')
                                                            ->live(debounce: 500)
                                                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state))),
                                                        TextInput::make('slug'),
                                                        KeyValue::make('alternames')->columnSpan(2),
                                                        TextInput::make('order_number')
                                                            ->required(),
                                                        
                                                    ])
                                                    ->columns(2),
                                            ])
                                            ->editOptionForm([
                                                Section::make()
                                                    ->schema([
                                                        TextInput::make('name')
                                                            ->live(debounce: 500)
                                                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str()->snake($state))),
                                                        TextInput::make('slug'),
                                                        KeyValue::make('alternames')->columnSpan(2),
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
