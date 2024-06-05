<?php

namespace App\Livewire\Components;

use Filament\Forms\Components\Textarea as FilamentTextarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class Textarea extends Component implements HasForms
{
    use InteractsWithForms;

    public $rows = 1;

    public $data = [
        'message' => '',
    ];

    public function render()
    {
        return view('components.livewire.textarea');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FilamentTextarea::make('message')
                    ->rows($this->rows)
                    ->required()
                    ->autosize()
                    ->hiddenLabel()
                    ->placeholder('Write a message...'),
            ])
            ->statePath('data');
    }
}
