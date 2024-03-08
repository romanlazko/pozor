<?php

namespace App\Livewire\Forms;

use App\Enums\Currency;
use App\Enums\Marketplace\Condition;
use App\Enums\Marketplace\Type;
use App\Enums\Status;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class MarketplaceAnnouncementForm extends Form
{
    use WithFileUploads;

    #[Validate(['type' => 'required'])]
    public Type $type = Type::sell;

    #[Validate(['title' => 'required'])]
    public $title = null;

    #[Validate(['photos.*' => 'image|max:1024|required'])]
    public $photos = [];

    #[Validate(['category_id' => 'exists:marketplace_categories,id|required'])]
    public $category_id = null;

    #[Validate(['subcategory_id' => 'exists:marketplace_subcategories,id|required'])]
    public $subcategory_id = null;

    #[Validate(['price' => 'required'])]
    public $price = null;

    #[Validate(['currency' => 'required'])]
    public Currency $currency = Currency::czk;

    #[Validate(['condition' => 'required'])]
    public Condition $condition;

    public $shipping;

    public $payment;

    #[Validate(['location' => 'required'])]
    public $location = [];

    #[Validate(['caption' => 'required'])]
    public $caption = null;

    public function save()
    {
        $this->validate();

        $announcement = auth()->user()->marketplaceAnnouncements()->create([
            'type'              => $this->type,
            'title'             => $this->title,
            'category_id'       => $this->category_id,
            'subcategory_id'    => $this->subcategory_id,
            'price'             => $this->price,
            'currency'          => $this->currency,
            'condition'         => $this->condition,
            // 'shipping'          => $this->shipping,
            // 'payment'           => $this->payment,
            'location'          => $this->location,
            'latitude'          => $this->location['lat'],
            'longitude'         => $this->location['long'],
            'should_be_published_in_telegram' => true,
            'caption'           => $this->caption,
            'status'            => Status::created,
            'status_info'       => [[
                'user' => auth()->user()->id,
                'status' => 'created',
                'datetime' => now()->format('Y-m-d H:s:i'),
            ]]
        ]);

        foreach ($this->photos as $photo) {
            $announcement->photos()->create([
                'src' => $photo->storePublicly(path: "marketplace/announcements/{$announcement->created_at->format('Y')}/{$announcement->created_at->format('F')}/{$announcement->created_at->format('d')}/{$announcement->slug}"  )
            ]);
        }

        if ($announcement) {
            $announcement->moderate();
        }
    }
}
