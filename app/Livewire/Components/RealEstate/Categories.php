<?php

namespace App\Livewire\Components\RealEstate;

use App\Models\RealEstate\RealEstateCategory;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Categories extends Component
{
    public $category;

    #[Modelable]
    public $category_id;

    public $local_category_id;
    public $category_items = [];

    public function render()
    {
        $this->category = RealEstateCategory::find($this->local_category_id);
        $this->category_items = $this->category?->children ?? RealEstateCategory::where('parent_id', null)->get();

        if ($this->category?->children->isEmpty()) {
            $this->category_id = $this->local_category_id;
        }
        return view('livewire.components.real-estate.categories');
    }
}
