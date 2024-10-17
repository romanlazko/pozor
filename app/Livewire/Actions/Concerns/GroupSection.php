<?php

namespace App\Livewire\Actions\Concerns;

use App\Models\AttributeGroup;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

trait GroupSection 
{
    public static function getGroupSection(): ?Section
    {
        return Section::make(__("Group"))
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
            ->columns(3);
    }
}