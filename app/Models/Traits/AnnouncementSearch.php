<?php

namespace App\Models\Traits;

use App\AttributeType\AttributeFactory;
use App\Enums\Sort;
use App\Enums\Status;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

trait AnnouncementSearch
{
    public function scopeCategory($query, Category|null $category)
    {
        return $query->when($category, fn ($query) 
            => $query->whereHas('categories', fn ($query) 
                => $query->where('category_id', $category->id)->select('categories.id')
        ));
    }
    public function scopeFeatures($query, Category|null $category, array|null $attributes)
    {
        return $query->where(function ($query) use ($attributes, $category) {
            $category_attributes = Cache::remember($category?->slug.'_search_attributes', config('cache.ttl'), fn () 
                => Attribute::select('id', 'visible', 'name', 'search_type')
                    ->withCount('attribute_options')
                    ->with('attribute_options:id,attribute_id,is_default,is_null')
                    ->when($category, function ($query) use ($category) {
                        $categoryIds = $category
                            ->getParentsAndSelf()
                            ->pluck('id')
                            ->toArray();
                        
                        $query->whereHas('categories', fn ($query) 
                            => $query->whereIn('category_id', $categoryIds ?? [])
                                ->select('categories.id')
                        );
                    })
                    
                    ->when(!$category, fn ($query) 
                        => $query->where('always_required', true)
                    )
                    ->where('filterable', true)
                    ->get()
            );

            foreach ($category_attributes as $attribute) {
                AttributeFactory::applyQuery($attribute, $attributes, $query);
            }
        });
    }

    public function scopeIsPublished($query)
    {
        return $query->whereHas('currentStatus', fn ($query) 
            => $query->where('status', Status::published)
        );
    }

    public function scopeSort($query, Sort $sort = null)
    {
        // return $query->when($sort, fn ($query) 
        //     => $query->orderBy($sort->orderBy(), $sort->type())
        // );

        return $sort->query($query);
    }
}