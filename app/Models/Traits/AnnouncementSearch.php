<?php

namespace App\Models\Traits;

use App\Enums\Sort;
use App\Enums\Status;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

trait AnnouncementSearch
{
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
                Cache::remember($category?->slug.'_search_attributes', 3600, function () use ($category) {
                    return  
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
                });


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

    public function scopeIsPublished($query)
    {
        return $query->whereHas('currentStatus', fn ($query) => $query->where('status', Status::published));
    }

    public function scopeSort($query, Sort $sort = null)
    {
        return $query->when($sort, fn ($query) => $query->orderBy($sort->orderBy(), $sort->type()));
    }
}