<?php

namespace App\Models;

use Akuechler\Geoly;
use App\Enums\Sort;
use App\Enums\Status;
use App\Models\Attribute;
use App\Models\Traits\AnnouncementTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;
use Romanlazko\Telegram\Models\TelegramChat;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Announcement extends Model implements HasMedia, Auditable
{
    use HasSlug; use SoftDeletes; use Geoly; use InteractsWithMedia; use AuditingAuditable; use AnnouncementTrait;

    protected $guarded = [];

    protected $casts = [
        // 'title' => 'array',
        // 'description' => 'array',
        'translated_title' => 'array',
        'description_description' => 'array',
        'location' => 'array',
        'status' => Status::class,
    ];

    protected static function booted(): void
    {
        // static::creating(function (Announcement $announcement) {
        //     $announcement->title = [
        //         'original' => $announcement->title,
        //     ];
        //     $announcement->description = [
        //         'original' => $announcement->description,
        //     ];
        // });

        static::updating(function (Announcement $announcement) {
            if ($announcement->isDirty('title')) {
                $announcement->translated_title = null;
            }

            if ($announcement->isDirty('description')) {
                $announcement->translated_description = null;
            }
        });
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('responsive-images')
            ->greyscale()
            ->quality(50)
            ->withResponsiveImages();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('announcements')
            ->withResponsiveImages();
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

    public function getTranslatedTitleAttribute()
    {
        return json_decode($this->attributes['translated_title'], true)[app()->getLocale()] ?? null;
    }

    public function getOriginalTitleAttribute()
    {
        return $this->title;
    }

    public function getTranslatedDescriptionAttribute()
    {
        return json_decode($this->attributes['translated_description'], true)[app()->getLocale()] ?? null;
    }

    public function getOriginalDescriptionAttribute()
    {
        return $this->description;
    }

    public function currency()
    {
        return $this->belongsTo(AttributeOption::class, 'currency_id', 'id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->using(AnnouncementAttribute::class)->withPivot('value');
    }

    public function scopeCategories($query, Category|null $category)
    {
        return $query->when($category, fn ($query) => 
            $query->whereHas('categories', fn ($query) 
                => $query->where('category_id', $category->id)
        ));
    }

    public function scopeFeatures($query, Category|null $category, array|null $attributes)
    {
        return $query->when($category and $attributes, fn ($query) =>
            $query->where(function ($query) use ($attributes, $category) {
                $category_attributes = Attribute::whereHas('categories', fn ($query) => $query->whereIn('category_id', $category->getParentsAndSelf()->pluck('id')->toArray()))->get();

                foreach ($category_attributes as $attribute) {
                    if ($attribute->is_feature AND $attribute->searchable AND isset($attributes[$attribute->name]) AND !empty($attributes[$attribute->name])) {
                        $query->whereHas('attributes', function ($query) use ($attribute, $attributes){
                            if ($attribute->search_type == 'between') {
                                $max = !empty($attributes[$attribute->name]['max']) ? $attributes[$attribute->name]['max'] : PHP_INT_MAX;
                                $min = !empty($attributes[$attribute->name]['min']) ? $attributes[$attribute->name]['min'] : 0;
                                $query->where('value->original', '>=', $min)->where('value->original', '<=', $max);
                            }
                            else if ($attribute->search_type == 'checkboxlist') {
                                $query->whereIn('value->original', $attributes[$attribute->name]);
                            }
                            else {
                                $query->where('value->original', $attributes[$attribute->name]);
                            }
                        });
                    }
                }
            })
        );
    }

    public function scopePrice($query, $price = null)
    {
        return $query->when($price, function ($query) use ($price) {
            $priceMax = !empty($price['max']) ? $price['max'] : PHP_INT_MAX;
            $priceMin = !empty($price['min']) ? $price['min'] : 0;

            $query->whereBetween('current_price', [$priceMin, $priceMax]);
        });
    }

    public function scopeSearch($query, $search = null, $search_in_description = false)
    {
        $query->when($search, fn ($query) => 
            $query->whereRaw('LOWER(translated_title) LIKE ?', ['%' . mb_strtolower($search) . '%'])
                ->when($search_in_description, fn ($query) => $query->orWhereRaw('LOWER(translated_description) LIKE ?', ['%' . mb_strtolower($search) . '%'])));
    }

    public function scopeSort($query, Sort $sort = null)
    {
        return $query->when($sort, fn ($query) => $query->orderBy($sort->orderBy(), $sort->type()));
    }

    public function scopeIsPublished($query)
    {
        return $query->where('status', Status::published);
    }
}
