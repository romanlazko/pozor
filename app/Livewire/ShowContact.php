<?php

namespace App\Livewire;

use App\Models\Announcement;
use App\Models\User;
use App\Notifications\NewMessage;
use Livewire\Component;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
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
            ->extraAttributes(['class' => "border border-green-500 rounded-xl"])
            ->iconButton()
            ->color('success')
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

    // public function submit()
    // {
    //     try {
    //         if ($this->recaptchaPasses()) {
    //             $this->user = User::where('id', $this->user_id)->select('phone', 'email', 'telegram_chat_id')->first();
    //         }
    //     } catch (\Exception $e) {
    //         $this->error = $e->getMessage();
    //     }
    // }
}
