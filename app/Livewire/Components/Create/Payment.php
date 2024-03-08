<?php

namespace App\Livewire\Components\Create;

use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Payment extends Component
{
    #[Reactive]
    public $error;
    
    #[Modelable]
    public $payment = null;

    public function render()
    {
        return view('livewire.components.create.payment');
    }
}
