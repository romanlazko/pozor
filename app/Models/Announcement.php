<?php

namespace App\Models;

use Akuechler\Geoly;
use App\Enums\Sort;
use App\Enums\Status;
use App\Models\Attribute;
use App\Models\Traits\AnnouncementTrait;
use Igaster\LaravelCities\Geo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Romanlazko\Telegram\Models\TelegramChat;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Announcement extends Model implements HasMedia, Auditable
{
    use HasSlug, HasFactory; use SoftDeletes; use Geoly; use InteractsWithMedia; use AuditingAuditable; use AnnouncementTrait; use HasSEO;

    protected $guarded = [];

    protected $casts = [
        'translated_title' => 'array',
        'description_description' => 'array',
        'location' => 'array',
        'status' => Status::class,
    ];

    protected $with = ['media'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(function ($model) {
                return $model->getFeatureByName('title')->translated_value['original'];
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

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function features()
    {
        return $this->hasMany(Feature::class);
    }

    public function geo()
    {
        return $this->belongsTo(Geo::class);
    }

    public function getFeatureByName($name)
    {
        return $this->features->firstWhere('attribute.name', $name);
    }

    public function getFeatureByNameAndPull($name)
    {
        $feature = $this->getFeatureByName($name);

        if ($feature) {
            $this->features->forget($this->features->search($feature));
        }
        
        return $feature ?? null;
    }

    public function attribute_options()
    {
        return $this->attributes()->with('attribute_options');
    }

    public function scopeCategories($query, Category|null $category)
    {
        return $query->when($category, fn ($query) => 
            $query->whereHas('categories', fn ($query) 
                => $query->where('category_id', $category->id)->select('categories.id')
        ));
    }

    public function scopeFeatures($query, Category|null $category, array|null $attributes)
    {
        return 
            $query->where(function ($query) use ($attributes, $category) {

                $category_attributes = 
                // Cache::remember($category->slug.'_search_attributes', 3600, function () use ($category) {
                    Attribute::select('id', 'visible', 'name', 'search_type')
                        ->withCount('attribute_options')
                        ->when($category, function ($query) use ($category) {
                            $categoryIds = $category
                                ->getParentsAndSelf()
                                ->pluck('id')
                                ->toArray();
                            
                            $query->whereHas('categories', fn ($query) => $query->whereIn('category_id', $categoryIds ?? [])->select('categories.id'));
                        })
                        
                        ->when(!$category, function ($query) { 
                            $query->where('always_required', true);
                        })
                        ->where('filterable', true)
                        ->get();
                // });


                foreach ($category_attributes as $attribute) {
                    if (isset($attributes[$attribute->name]) AND !empty($attributes[$attribute->name]) AND $attributes[$attribute->name] != null) {
                        $className = "App\\AttributeType\\".str_replace('_', '', ucwords($attribute->search_type, '_'));

                        $attributeType = new $className($attribute, $attributes);

                        if ($attributeType->isVisible()) {
                            $attributeType->apply($query);
                        }
                    }
                }
            });
    }

    // public function isVisible(array $attributes, Attribute $attribute)
    // {
    //     if (empty($attribute->visible_condition)) {
    //         return true;
    //     }

    //     foreach ($attribute->visible_condition as $condition) {
    //         if ($attributes[$condition['attribute_name']] == $condition['value']) return true;
    //     }

    //     return false;
    // }

    public function scopeSort($query, Sort $sort = null)
    {
        return $query->when($sort, fn ($query) => $query->orderBy($sort->orderBy(), $sort->type()));
    }

    public function scopeIsPublished($query)
    {
        return $query->where('status', Status::published);
    }

    public function getMetaAttribute()
    {
        $title = $this->getFeatureByName('title')->value ?? '';
        $currentPrice = $this->current_price ?? $this->salary ?? '';
        $currency = $this->getFeatureByName('currency')->value ?? '';
        $description = $this->getFeatureByName('description')->value ?? '';
        $categories = $this->categories->pluck('name')->implode(' | ');

        return [
            'title' => $title,
            'meta_title' => "$title - $currentPrice $currency | $categories",
            'description' => "$title - $currentPrice $currency | $categories | $description",
            'image_url' => $this->getFirstMediaUrl('announcement'),
            'image_alt' => "$title | $categories",
            'price' => $currentPrice,
            'currency' => $currency,
            'category' => $categories,
            'author' => $this->user->name ?? '',
            'date' => $this->created_at ?? '',
        ];
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

    public function getTitleAttribute()
    {
        return $this->getFeatureByName('title')?->value;
    }

    public function getCurrentPriceAttribute()
    {
        return $this->getFeatureByName('current_price')?->value;
    }

    public function getSalaryAttribute()
    {
        return $this->getFeatureByName('salary')?->value;
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function userVotes()
    {
        return $this->votes()->one()->where('user_id', auth()->id());
    }
}
