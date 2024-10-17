<?php

namespace App\Livewire\Actions\Concerns;

use App\Models\AttributeSection;
use Closure;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;

trait CreateLayoutSection 
{
    use AttributeSectionFormSection;

    public static function getCreateLayoutSection(): ?Section
    {
        return Section::make(__("Create layout"))
            ->schema([
                Grid::make(3)
                    ->schema([
                        Select::make('create_layout.type')
                            ->options(self::$type_options)
                            ->required()
                            ->helperText("Тип атрибута при создании объявления.")
                            ->afterStateUpdated(function (Get $get, Set $set, $state) { 
                                if (!$get('filter_layout.type')) {
                                    $set('filter_layout.type', $state);
                                }
                                
                                if (!$get('show_layout.type')) {
                                    $set('show_layout.type', $state);
                                }
                            })
                            ->afterStateHydrated(fn ($state, Set $set) => $set('show_layout.type', $state))
                            ->columnSpanFull()
                            ->live(),
                        
                        Select::make('create_layout.rules')
                            ->label('Validation rulles')
                            ->multiple()
                            ->required()
                            ->columnSpanFull()
                            ->options(self::$validation_rules)
                            ->visible(fn (Get $get) => in_array($get('create_layout.type'), array_keys(self::$type_options['text_fields']))),
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
                            ->editOptionForm([
                                self::getAttributeSectionFormSection()
                            ])
                            ->createOptionForm([
                                self::getAttributeSectionFormSection()
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

                        Toggle::make('is_translatable')
                            ->helperText(__("Будет ли переводится этот атрибут автоматически"))
                            ->visible(fn (Get $get) => in_array($get('create_layout.type'), array_keys(self::$type_options['text_fields']))),

                        Toggle::make('is_required')
                            ->helperText(__("Является ли этот атрибут обязательным при создании объявления")),
                    ])
                    ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg border border-gray-200']),

            ])
            ->columns(3);
    }
}