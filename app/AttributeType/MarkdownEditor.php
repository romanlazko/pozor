<?php

namespace App\AttributeType;

use App\Facades\Purifier;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor as ComponentsMarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select as ComponentsSelect;
use Filament\Forms\Components\Textarea as ComponentsTextarea;
use Filament\Forms\Components\TextInput as ComponentsTextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Guava\FilamentClusters\Forms\Cluster;
use Filament\Forms\Components\ToggleButtons as ComponentsToggleButtons;

class MarkdownEditor extends BaseAttributeType
{
    public function apply($query)
    {
        $query->whereHas('features', function ($query) {
            $query->where('attribute_id', $this->attribute->id)->where('attribute_option_id', $this->data[$this->attribute->name]);
        });

        return $query;
    }

    public function getCreateComponent(Get $get = null)
    {
        return ComponentsMarkdownEditor::make('attributes.'.$this->attribute->name)
            ->label($this->attribute->label)
            ->columnSpan(['default' => 'full', 'sm' => $this->attribute->column_span])
            ->columnStart(['default' => '1', 'sm' => $this->attribute->column_start])
            ->visible(fn (Get $get) => $this->isVisible($get))
            ->hidden(fn (Get $get) => $this->isHidden($get))
            ->required($this->attribute->required)
            ->toolbarButtons([
                'bold',
                'bulletList',
                'italic',
                'orderedList',
                'redo',
                'undo',
            ])
            ->dehydrateStateUsing(fn (string $state) => Purifier::purify($state));
    }
}