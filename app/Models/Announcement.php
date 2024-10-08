<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use App\Models\TelegramChat;
use App\Models\Traits\AnnouncementSearch;
use App\Models\Traits\AnnouncementStatus;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Announcement extends Model implements HasMedia, Auditable
{
    use HasSlug, HasFactory; 
    use SoftDeletes;
    use InteractsWithMedia; 
    use AuditingAuditable; 
    use HasSEO; 
    use AnnouncementSearch;
    use AnnouncementStatus; 

    protected $guarded = [];

    protected $casts = [
        'current_status' => Status::class,
    ];

    protected static function booted(): void
    {
        static::created(function (Announcement $announcement) {
            $announcement->statuses()->create(['status' => Status::created]);
        });

        // static::retrieved(function (Announcement $announcement) {
        //     $features = $announcement->features;

        //     foreach ($features as $feature) {
        //         $announcement->setAttribute($feature->attribute->name, $feature);
        //     }
        // });
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(function ($model) {
                return $model?->title ?? $model->uuid;
            })
            ->skipGenerateWhen(function () {
                return $this->features->isEmpty();
            })
            ->doNotGenerateSlugsOnCreate()
            ->saveSlugsTo('slug');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('responsive-images')
            ->withResponsiveImages();

        $this
            ->addMediaConversion('thumb')
            ->format('webp')
            ->width(100)
            ->height(100);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('announcements');
    }

    public function chat()
    {
        return $this->belongsTo(TelegramChat::class, 'telegram_chat_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function features()
    {
        return $this->hasMany(Feature::class);
    }

    public function geo()
    {
        return $this->belongsTo(Geo::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function userVotes()
    {
        return $this->votes()->one()->where('user_id', auth()->id());
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function channels()
    {
        return $this->hasMany(AnnouncementChannel::class, 'announcement_id', 'id');
    }

    public function getFeatureByName(string $name)
    {
        return $this->features->firstWhere('attribute.name', $name);
    }

    public function getSectionByName(string $name)
    {
        return $this->features->groupBy('attribute.showSection.slug')
            ?->get($name)
            ?->sortBy('attribute.show_layout.order_number');
    }

    public function getGroupByName(string $name)
    {
        return $this->features->groupBy('attribute.group.slug')
            ?->get($name)
            ?->sortBy('attribute.group_layout.order_number');
    }

    public function getTitleAttribute()
    {
        return $this->getGroupByName('title')?->pluck('value')->implode(', ');
    }

    public function getPriceAttribute()
    {
        return $this->getGroupByName('price')?->pluck('value')->implode(' ');
    }

    public function getDescriptionAttribute()
    {
        return $this->getGroupByName('description')?->pluck('value')->implode(' ');
    }

    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->getFeatureByName('title')?->value,
            description: $this->getFeatureByName('description')?->value,
            author: $this->user?->name,
            image: $this->getFirstMediaUrl('announcements'),
            url: url()->current(),
            enableTitleSuffix: true,
            site_name: config('app.name'),
            published_time: $this->created_at,
            modified_time: $this->updated_at,
            locale: app()->getLocale(),
            section: $this->categories->pluck('name')->implode(', '),
            tags: $this->categories->pluck('name')->toArray(),
        );
    }
}
