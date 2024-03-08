<?php

namespace App\Livewire\Forms;

use App\Enums\Currency;
use App\Enums\RealEstate\Condition;
use App\Enums\RealEstate\Equipment;
use App\Enums\RealEstate\Type;
use App\Enums\Status;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class RealEstateAnnouncementForm extends Form
{
    use WithFileUploads;

    #[Validate(['type' => 'required'])]
    public Type $type = Type::rent;

    #[Validate(['photos.*' => 'image|max:1024|required'])]
    public $photos = [];

    #[Validate(['category_id' => 'exists:real_estate_categories,id|required'])]
    public $category_id = 1;

    // #[Validate(['subcategory_id' => 'exists:real_estate_subcategories,id'])]
    public $subcategory_id = null;

    // #[Validate(['configuration_id' => 'exists:real_estate_configurations,id'])]
    public $configuration_id = null;

    #[Validate(['price' => 'required'])]
    public $price = null;

    #[Validate(['price_currency' => 'required'])]
    public Currency $price_currency = Currency::czk;

    #[Validate(['deposit' => 'sometimes'])]
    public $deposit = null;

    #[Validate(['deposit_currency' => 'required'])]
    public Currency $deposit_currency = Currency::czk;

    #[Validate(['utilities' => 'required'])]
    public $utilities = null;

    #[Validate(['utilities_currency' => 'required'])]
    public Currency $utilities_currency = Currency::czk;

    #[Validate(['square_meters' => 'required'])]
    public $square_meters = null;

    #[Validate(['check_in_date' => 'required'])]
    public $check_in_date = null;

    #[Validate(['additional_spaces' => 'required'])]
    public $additional_spaces = [];

    #[Validate(['equipment' => 'required'])]
    public Equipment $equipment = Equipment::full;

    #[Validate(['floor' => 'required'])]
    public $floor = null;

    #[Validate(['address' => 'required'])]
    public $address;

    #[Validate(['condition' => 'required'])]
    public Condition $condition;

    #[Validate(['location' => 'required'])]
    public $location = [];

    #[Validate(['description' => 'required'])]
    public $description = null;

    public function save()
    {
        $this->validate();

        $announcement = auth()->user()->realEstateAnnouncements()->create([
            'description'       => $this->description,
            'type'              => $this->type,
            'category_id'       => $this->category_id,
            'subcategory_id'    => $this->subcategory_id,
            'configuration_id'  => $this->configuration_id,
            'price'             => $this->price,
            'price_currency'    => $this->price_currency,
            'deposit'           => $this->deposit,
            'deposit_currency'  => $this->deposit_currency,
            'utilities'         => $this->utilities,
            'utilities_currency'=> $this->utilities_currency,
            'condition'         => $this->condition,
            'square_meters'     => $this->square_meters,
            'check_in_date'     => $this->check_in_date,
            'additional_spaces' => $this->additional_spaces,
            'equipment'         => $this->equipment,
            'floor'             => $this->floor,
            'location'          => $this->location,
            'latitude'          => $this->location['lat'],
            'longitude'         => $this->location['long'],
            'address'           => $this->address,
        
            'should_be_published_in_telegram' => true,
            'status'            => Status::created,
            'status_info'       => [[
                'user' => auth()->user()->id,
                'status' => 'created',
                'datetime' => now()->format('Y-m-d H:s:i'),
            ]],
        ]);

        foreach ($this->photos as $photo) {
            $announcement->photos()->create([
                'src' => $photo->storePublicly(path: "real-estate/announcements/{$announcement->created_at->format('Y')}/{$announcement->created_at->format('F')}/{$announcement->created_at->format('d')}/{$announcement->slug}"  )
            ]);
        }

        if ($announcement) {
            $announcement->moderate();
        }
    }
}
