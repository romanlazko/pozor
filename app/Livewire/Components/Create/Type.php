<?php

namespace App\Livewire\Components\Create;

use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Type extends Component
{
    #[Reactive]
    public $error;
    
    #[Modelable] 
    public $type;
    
    public array $types = [];

    public function render()
    {
        return view('livewire.components.create.type');
    }
}
