<?php

namespace App\Livewire\Components\Marketplace;

use App\Models\Marketplace\MarketplaceCategory as MarketplaceMarketplaceCategory;
use Livewire\Component;

class MarketplaceCategory extends Component
{
    public null|MarketplaceMarketplaceCategory $category;
    public $category_id;
    public $category_items = [];

    public function mount()
    {
        $this->category_id = MarketplaceMarketplaceCategory::where('slug', request()->category)->first()?->id;
    }

    public function render()
    {
        $this->category = MarketplaceMarketplaceCategory::find($this->category_id);
        $this->category_items = $this->category?->children ?? MarketplaceMarketplaceCategory::where('parent_id', null)->get();
        return view('livewire.components.marketplace.marketplace-category');
    }
}
