<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model implements HasMedia
{
    use HasFactory; use HasSlug; use SoftDeletes; use InteractsWithMedia; use HasSEO;

    protected $guarded = [];

    protected $casts = [
        'alternames' => 'array' 
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('categories')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->keepOriginalImageFormat()
                    ->width(200);
            });
    }

    public function announcements()
    {
        return $this->belongsToMany(Announcement::class);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function getNameAttribute()
    {
        return $this->alternames[app()->getLocale()] ?? $this->alternames['en'] ?? null;
    }

    public function getTranslatedNameAttribute()
    {
        return $this->alternames[app()->getLocale()] ?? $this->alternames['en'] ?? null;
    }

    public function getChildren()
    {
        $children = collect([$this]);

        foreach ($this->children as $child) {
            foreach ($child->getChildren() as $child) {
                $children->add($child);
            }
        }

        return $children;
    }

    // public function getParentsAndSelf()
    // {
    //     $parents = [$this];

    //     $currentCategory = $this;
    //     while ($currentCategory->parent) {
    //         $parents[] = $currentCategory->parent;
    //         $currentCategory = $currentCategory->parent;
    //     }

    //     return collect($parents)->reverse();
    // }

    public function getParentsAndSelf()
    {
        return collect([
            $this,
            ...$this->parent?->getParentsAndSelf() ?? []
        ]);
    }
    
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }

    private function getParent($parent)
    {
        foreach ($parent->parent as $parent) {
            $parents[] = $parent;
        }
    }

    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->name,
            description: $this->name,
            image: $this->getFirstMediaUrl('categories'),
            url: url()->current(),
            enableTitleSuffix: true,
            site_name: config('app.name'),
            published_time: $this->created_at,
            modified_time: $this->updated_at,
            locale: app()->getLocale(),
            section: $this->children->pluck('name')->implode(', '),
            tags: $this->children->pluck('name')->toArray(),
        );
    }
}
