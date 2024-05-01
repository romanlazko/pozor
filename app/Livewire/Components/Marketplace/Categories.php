<?php

namespace App\Livewire\Components\Marketplace;

use App\Models\Marketplace\MarketplaceCategory;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Categories extends Component
{
    
    public $category;

    #[Modelable]
    public $category_id;

    public $local_category_id;
    public $category_items = [];

    // public function mount()
    // {
    //     $this->category_id = old('category_id', request()->category_id);
    // }

    public function render()
    {
        $this->category = MarketplaceCategory::find($this->local_category_id);
        $this->category_items = $this->category?->children ?? MarketplaceCategory::where('parent_id', null)->get();

        if ($this->category?->children->isEmpty()) {
            $this->category_id = $this->local_category_id;
        }

        return view('livewire.components.marketplace.categories');
    }
}
