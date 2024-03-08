<?php

namespace App\Livewire\RealEstate;

use App\Livewire\Forms\RealEstateAnnouncementForm;
use App\Models\RealEstate\RealEstateCategory;
use Stevebauman\Location\Facades\Location;
use Igaster\LaravelCities\Geo;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    #[Layout('layouts.user')]

    public RealEstateAnnouncementForm $form;

    public $category_items;

    public function mount()
    {
        $this->form->location = Geo::findName((Location::get(request()->ip()) ?: null)?->regionName)?->toArray();
        $this->category_items = RealEstateCategory::with('subcategories', 'configurations')->get();
    }

    public function render()
    {
        if ($this->form->photos) {
            foreach ($this->form->photos as $photo) {
                $photos[] = TemporaryUploadedFile::unserializeFromLivewireRequest($photo);
            }
            $this->form->photos = $photos;
        }

        $category = RealEstateCategory::find($this->form->category_id); 

        if (!$category?->subcategories->contains('id', $this->form->subcategory_id)) {
            $this->form->reset('subcategory_id');
        }

        if (!$category?->configurations->contains('id', $this->form->configuration_id)) {
            $this->form->reset('configuration_id');
        }
        
        return view('livewire.real-estate.create', compact('category'));
    }

    public function save()
    {
        $this->form->save();

        return redirect()->route('profile.announcements');
    }
}
