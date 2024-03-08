<?php

namespace App\Livewire\Marketplace;

use App\Enums\Filter;
use App\Enums\Marketplace\Type;
use App\Enums\Status;
use App\Livewire\Forms\MarketplaceSearchForm;
use App\Livewire\Traits\CompareArrays;
use App\Models\Marketplace\MarketplaceCategory;
use App\Models\Marketplace\MarketplaceAnnouncement;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination; use CompareArrays;

    #[Layout('layouts.user')]

    public MarketplaceSearchForm $form;

    public $category_items = [];

    public function mount()
    {
        $this->category_items = MarketplaceCategory::with('subcategories')->get();
    }

    public function render()
    {
        $announcements = MarketplaceAnnouncement::with('photos')->where('status', Status::published)
            ->search($this->form->search, $this->form->search_in_caption)
            ->filter($this->form->filter)
            ->type($this->form->type)
            ->priceRange($this->form->priceMin, $this->form->priceMax)
            ->condition($this->form->condition)
            ->category($this->form->category)
            ->subcategories($this->form->subcategories)
            ->location($this->form->location, $this->form->radius)
            ->paginate(50);

        return view('livewire.marketplace.index', ['announcements' => $announcements]);
    }

    public function updated()
    {
        $category = MarketplaceCategory::find($this->form->category); 

        if (!$category?->subcategories->whereIn('id', $this->form->subcategories)->isNotEmpty()) {
            $this->form->subcategories = [];
        }

        $this->resetPage();
    }

    public function submit()
    {
        $this->resetPage();
    }
}
