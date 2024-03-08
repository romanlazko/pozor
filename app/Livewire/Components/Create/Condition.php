<?php

namespace App\Livewire\Components\Create;

use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Condition extends Component
{
    #[Reactive]
    public $error;
    
    #[Modelable]
    public $condition = null;

    public array $conditions = [];

    public function render()
    {
        return view('livewire.components.create.condition');
    }
}
