<?php

namespace App\Livewire\RealEstate;

use App\Enums\Filter;
use App\Enums\RealEstate\Type;
use App\Enums\Status;
use App\Livewire\Forms\RealEstateSearchForm;
use App\Livewire\Traits\CompareArrays;
use App\Models\RealEstate\RealEstateAnnouncement;
use App\Models\RealEstate\RealEstateCategory;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination; use CompareArrays;

    #[Layout('layouts.user')]

    public RealEstateSearchForm $form;

    public $category_items;

    public $category;

    public function mount()
    {
        $this->category_items = RealEstateCategory::all();
    }

    public function render()
    {
        $announcements = RealEstateAnnouncement::with('configuration', 'photos')->where('status', Status::published)
            ->filter($this->form->filter)
            ->type($this->form->type)
            ->priceRange($this->form->priceMin, $this->form->priceMax)
            ->condition($this->form->condition)
            ->category($this->form->category)
            ->subcategories($this->form->subcategory)
            ->configuration($this->form->configurations)
            ->additionalSpaces($this->form->additional_spaces)
            ->squareMetersRange($this->form->minSquareMeters, $this->form->maxSquareMeters)
            ->floorRange($this->form->minFlore, $this->form->maxFlore)
            ->location($this->form->location, $this->form->radius)
            ->equipment($this->form->equipment)
            ->paginate(50);
            
        return view('livewire.real-estate.index', ['announcements' => $announcements]);
    }

    public function updated()
    {
        $this->category = RealEstateCategory::find($this->form->category);

        if (!$this->category?->subcategories->contains('id', $this->form->subcategory)) {
            $this->form->subcategory = null;
        }

        if (!$this->category?->configurations->whereIn('id', $this->form->configurations)->isNotEmpty()) {
            $this->form->configurations = [];
        }

        $this->resetPage();
    }

    public function submit()
    {
        $this->resetPage();
    }
}
