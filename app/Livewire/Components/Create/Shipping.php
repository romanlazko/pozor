<?php

namespace App\Livewire\Components\Create;

use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Shipping extends Component
{
    #[Reactive]
    public $error;
    
    #[Modelable]
    public $shipping = null;

    public function render()
    {
        return view('livewire.components.create.shipping');
    }
}
