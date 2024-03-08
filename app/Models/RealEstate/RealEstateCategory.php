<?php

namespace App\Models\RealEstate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class RealEstateCategory extends Model
{
    use HasFactory; use HasSlug; use SoftDeletes;

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

    public function subcategories()
    {
        return $this->hasMany(RealEstateSubcategory::class);
    }

    public function configurations()
    {
        return $this->hasMany(RealEstateConfiguration::class);
    }

    public function getNameAttribute()
    {
        return $this->alternames[app()->getLocale()] ?? $this->attributes['name'];
    }
}
