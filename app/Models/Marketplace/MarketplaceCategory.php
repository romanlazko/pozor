<?php
namespace App\Models\Marketplace;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class MarketplaceCategory extends Model
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

    public function children()
    {
        return $this->hasMany(MarketplaceCategory::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(MarketplaceCategory::class, 'parent_id', 'id');
    }

    public function getNameAttribute()
    {
        return $this->alternames[app()->getLocale()] ?? $this->attributes['name'];
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

    public function getAllParents()
    {
        $parents = [$this];

        $currentCategory = $this;
        while ($currentCategory->parent) {
            $parents[] = $currentCategory->parent;
            $currentCategory = $currentCategory->parent;
        }

        return collect($parents)->reverse();
    }    
}
