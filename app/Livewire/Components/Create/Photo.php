<?php

namespace App\Livewire\Components\Create;

use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithFileUploads;

class Photo extends Component
{
    use WithFileUploads;
 
    #[Reactive]
    public $error;
    
    #[Modelable]
    public $photos;

    public function render()
    {
        return view('livewire.components.create.photo');
    }

    public function deletePhoto($index)
    {
        unset($this->photos[$index]);
    }
}
