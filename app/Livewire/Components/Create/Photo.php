<?php

namespace App\Livewire\Components\Create;

use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Photo extends Component
{
    use WithFileUploads;
 
    // #[Validate(['photos.*' => 'image|max:1024'])]
    #[Modelable]
    public $photos = [];

    public function render()
    {
        return view('livewire.components.create.photo');
    }

    public function deletePhoto($index)
    {
        unset($this->photos[$index]);
    }
}
