<?php

namespace App\Livewire\Actions\Concerns;

use App\Models\Category;
use Closure;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Forms\Set;

trait NameSection
{
    public static function getNameSection(): ?Section
    {
        return Section::make(__('Name'))
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
            ->columns(2);
    }
}