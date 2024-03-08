<?php

namespace App\Livewire\Components\Create;

use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Title extends Component
{
    #[Reactive]
    public $error;
    
    #[Modelable]
    public $title = null;

    public function render()
    {
        return view('livewire.components.create.title');
    }
}
