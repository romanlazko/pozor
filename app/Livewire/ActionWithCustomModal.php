<?php

namespace App\Livewire;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Illuminate\Contracts\View\View;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Illuminate\View\ComponentAttributeBag;
use Livewire\Component;

class ActionWithCustomModal extends Action
{

    // public static function make(?string $name = null): static
    // {
    //     return parent::make($name)
    //         ->modalHeading(fn ($record) => $record->label)
    //         ->modalDescription(fn ($record) => $record->name)
    //         ->form([
    //             self::getCategorySection(),

    //             self::getNameSection(),

    //             self::getCreateLayoutSection(),

    //             self::getFilterLayoutSection(),

    //             self::getShowLayoutSection(),

    //             self::getGroupSection(),

    //             self::getOptionsSection(),

    //             self::getVisibleHiddenSection(),
    //         ])
    //         ->hiddenLabel()
    //         ->button()
    //         ->slideOver()
    //         ->extraModalWindowAttributes(['style' => 'background-color: #e5e7eb'])
    //         ->closeModalByClickingAway(false);
    // }
    
    public function render(): View
    {
        return view(
            'livewire.action-with-custom-modal',
            [
                'attributes' => new ComponentAttributeBag(),
                ...$this->extractPublicMethods(),
                ...(isset($this->viewIdentifier) ? [$this->viewIdentifier => $this] : []),
                ...$this->viewData,
            ]
        );
    }
}
