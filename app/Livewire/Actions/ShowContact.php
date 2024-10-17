<?php

namespace App\Livewire\Actions;

use App\Models\User;
use Livewire\Component;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Lukeraymonddowning\Honey\Traits\WithRecaptcha;

class ShowContact extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;
    use WithRecaptcha;
    
    public $user_id;

    public function showContact()
    {
        $user = User::where('id', $this->user_id)->first();

        return Action::make('showContact')
            ->icon('heroicon-s-phone')
            ->extraAttributes(['class' => 'w-full'])
            ->button()
            ->color('primary')
            ->modalHeading(' ')
            ->modalWidth('xl')
            ->modalSubmitAction(false)
            ->modalCancelAction(false)
            ->modalContentFooter(view('components.livewire.show-contact', ['user' => $user]));
    }

    public function render()
    {
        return view('livewire.show-contact');
    }
}
