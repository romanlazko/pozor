<?php

namespace App\Livewire\Pages\Admin\Settings;

use App\Livewire\Actions\Concerns\CategorySection;
use App\Livewire\Pages\Layouts\AdminLayout;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Sorting;
use Closure;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Sortings extends AdminLayout implements HasForms, HasTable
{
    use CategorySection;

    public function table(Table $table): Table
    {
        return $table
            ->query(Sorting::query())
            ->headerActions([
                CreateAction::make()
                    ->form([
                        Section::make()
                            ->columns(2)
                            ->schema([
                                KeyValue::make('alternames')
                                    ->label('Label')
                                    ->keyLabel(__('Language'))
                                    ->valueLabel(__('Value'))
                                    ->columnSpan(1)
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
                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('slug')
                                            ->required(),

                                        TextInput::make('order_number')
                                            ->helperText(__('Порядковый номер сортировки.'))
                                            ->numeric()
                                            ->required(),
                                    ])
                                    ->columnSpan(1)
                                
                            ])
                            ->columns(2),
                        Section::make()
                            ->schema([
                                Select::make('categories')
                                    ->helperText("Категории к которым принадлежит сортировка. (можно выбрать несколько)")
                                    ->relationship('categories')
                                    ->multiple()
                                    ->options(Category::all()->groupBy('parent.name')->map->pluck('name', 'id'))
                                    ->columnSpanFull()
                                    ->live(),
                            ]),
                        Section::make()
                            ->schema([
                                Select::make('attribute_id')
                                    ->relationship('attribute')
                                    ->options(fn (Get $get) => Attribute::whereHas('categories', fn ($query) => $query->whereIn('category_id', $get('categories') ?? []))->pluck('name', 'id')),
                                Select::make('direction')
                                    ->options([
                                        'asc' => 'ASC',
                                        'desc' => 'DESC',
                                    ])
                            ])
                    ])
                    ->slideOver()
                    ->extraModalWindowAttributes(['style' => 'background-color: #e5e7eb']),
            ])
            ->columns([
                TextColumn::make('order_number')
                    ->label('#Order'),
                TextColumn::make('name')
                    ->description(fn (Sorting $record): string =>  $record?->direction),
                ToggleColumn::make('is_default')
                    ->beforeStateUpdated(function ($record, $state) {
                        if ($state) {
                            Sorting::query()->where('is_default', 1)->update(['is_default' => 0]);
                        }
                    }),
                TextColumn::make('attribute.label')
                    ->badge()
                    ->color('info'),
                TextColumn::make('categories')
                    ->state(fn (Sorting $record) => $record->categories->pluck('name'))
                    ->badge()
                    ->color('success')
                    ->grow(false),
                TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->actions([
                EditAction::make()
                    ->form([
                        Section::make()
                            ->columns(2)
                            ->schema([
                                KeyValue::make('alternames')
                                    ->label('Label')
                                    ->keyLabel(__('Language'))
                                    ->valueLabel(__('Value'))
                                    ->columnSpan(1)
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
                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('slug')
                                            ->required(),

                                        TextInput::make('order_number')
                                            ->helperText(__('Порядковый номер сортировки.'))
                                            ->numeric()
                                            ->required(),
                                    ])
                                    ->columnSpan(1)
                                
                            ])
                            ->columns(2),
                        Section::make()
                            ->schema([
                                Select::make('categories')
                                    ->helperText("Категории к которым принадлежит сортировка. (можно выбрать несколько)")
                                    ->relationship('categories')
                                    ->multiple()
                                    ->options(Category::all()->groupBy('parent.name')->map->pluck('name', 'id'))
                                    ->columnSpanFull()
                                    ->live(),
                            ]),
                        Section::make()
                            ->schema([
                                Select::make('attribute_id')
                                    ->relationship('attribute')
                                    ->options(fn (Get $get) => Attribute::whereHas('categories', fn ($query) => $query->whereIn('category_id', $get('categories') ?? []))->pluck('name', 'id')),
                                Select::make('direction')
                                    ->options([
                                        'asc' => 'ASC',
                                        'desc' => 'DESC',
                                    ])
                            ])
                    ])
                    ->hiddenLabel()
                    ->button(),
                DeleteAction::make()
                    ->hiddenLabel()
                    ->button()
            ]);
    }
}