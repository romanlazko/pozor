<?php

namespace App\Livewire\Components\Create;

use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Currency extends Component
{
    public $label = "⠀";

    #[Reactive]
    public $error;
    
    #[Modelable]
    public $currency = null;

    public function render()
    {
        return view('livewire.components.create.currency');
    }
}
