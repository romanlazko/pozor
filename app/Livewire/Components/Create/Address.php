<?php

namespace App\Livewire\Components\Create;

use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Address extends Component
{
    #[Reactive]
    public $error;

    #[Modelable]
    public $address = null;

    public function render()
    {
        return view('livewire.components.create.address');
    }
}
