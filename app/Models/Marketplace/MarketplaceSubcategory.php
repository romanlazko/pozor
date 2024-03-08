<?php
namespace App\Models\Marketplace;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class MarketplaceSubcategory extends Model
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

    public function category()
    {
        return $this->belongsTo(MarketplaceCategory::class, 'marketplace_category_id', 'id');
    }

    public function getNameAttribute()
    {
        return $this->alternames[app()->getLocale()] ?? $this->attributes['name'];
    }
}
