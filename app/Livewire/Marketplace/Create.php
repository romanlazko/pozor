<?php

namespace App\Livewire\Marketplace;

use App\Livewire\Forms\MarketplaceAnnouncementForm;
use App\Models\Marketplace\MarketplaceCategory;
use Igaster\LaravelCities\Geo;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Stevebauman\Location\Facades\Location;

class Create extends Component
{
    use WithFileUploads;

    #[Layout('layouts.user')]

    public MarketplaceAnnouncementForm $form;

    public $category_items;

    public $subcategory_items;

    public function mount()
    {
        $this->form->location = Geo::findName((Location::get(request()->ip()) ?: null)?->regionName)?->toArray();
        $this->category_items = MarketplaceCategory::with('subcategories')->get();
    }

    public function render()
    {
        if ($this->form->photos) {
            foreach ($this->form->photos as $photo) {
                $photos[] = TemporaryUploadedFile::unserializeFromLivewireRequest($photo);
            }
            $this->form->photos = $photos;
        }

        $category = MarketplaceCategory::find($this->form->category_id); 

        if (!$category?->subcategories->contains('id', $this->form->subcategory_id)) {
            $this->form->reset('subcategory_id');
        }
        
        return view('livewire.marketplace.create', compact('category'));
    }

    public function save()
    {
        $this->form->save();

        return redirect()->route('profile.announcements');
    }
}
