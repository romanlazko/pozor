<?php

namespace App\Models\Marketplace;

use Akuechler\Geoly;
use App\Enums\Currency;
use App\Enums\Marketplace\Condition;
use App\Enums\Marketplace\Type;
use App\Enums\Status;
use App\Models\Traits\AnnouncementSearch;
use App\Models\Traits\AnnouncementTrait;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Romanlazko\Telegram\Models\TelegramChat;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class MarketplaceAnnouncement extends Model
{
    use HasFactory; use HasSlug; use SoftDeletes; use Geoly; use AnnouncementTrait; use AnnouncementSearch;

    protected $guarded = [];

    protected $casts = [
        'status_info' => 'array',
        'location' => 'array',
        'type' => Type::class,
        'condition' => Condition::class,
        'status' => Status::class,
        'currency' => Currency::class,
        'keys' => 'array',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function photos()
    {
        return $this->hasMany(MarketplaceAnnouncementPhoto::class, 'announcement_id', 'id');
    }

    public function chat()
    {
        return $this->belongsTo(TelegramChat::class, 'telegram_chat_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(MarketplaceCategory::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(MarketplaceSubcategory::class);
    }

    public function prepareForTelegram()
    {
        $text = [];

        if ($this->type) {
            $text['type'] = $this->type->hashTag();
        }

        if ($this->title) {
            $text['title'] = "<b>{$this->title}</b>";
        }

        if ($this->caption) {
            $text['caption'] = $this->caption;
        }

        if ($this->condition) {
            $text['condition'] = "<i>Состояние:</i> " . $this->condition->trans('ru');
        }

        if ($this->price) {
            $text['price'] = "<i>Стоимость:</i> {$this->price} {$this->currency->value}";
        }

        if ($this->category) {
            $category = str_replace(' ', '', $this->category->name);
            $subcategory = str_replace(' ', '', $this->subcategory->name);

            $text['category'] = "#{$category} #{$subcategory}";
        }

        if ($this->payment) {
            $text['payment'] = "<i>Предпочитаемый способ оплаты:</i> {$this->payment}";
        }

        if ($this->shipping) {
            $text['shipping'] = "<i>Доставка:</i> {$this->shipping}";
        }

        return implode("\n\n", $text);
    }
}
