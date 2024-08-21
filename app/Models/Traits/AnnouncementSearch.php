<?php

namespace App\Models\Traits;

use App\AttributeType\AttributeFactory;
use App\Enums\Sort;
use App\Enums\Status;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

use function JmesPath\search;

trait AnnouncementSearch
{
    public function scopeCategory($query, Category|null $category)
    {
        return $query->when($category, fn ($query) 
            => $query->whereHas('categories', fn ($query) 
                => $query->where('category_id', $category->id)->select('categories.id')
        ));
    }
    public function scopeFeatures($query, $searchAttributes, array|null $attributes)
    {
        if ($searchAttributes->isEmpty() OR !$attributes) {
            return $query;
        }

        return $query->where(function (Builder $query) use ($attributes, $searchAttributes) {
            foreach ($searchAttributes as $attribute) {
                AttributeFactory::applyQuery($attribute, $attributes, $query);
            }
        });
    }

    public function scopeIsPublished($query)
    {
        return $query->where('current_status', Status::published);
    }

    public function scopeSearch($query, string $search)
    {
        if (!$search) {
            return $query;
        }
        
        return $query->whereHas('features', fn ($query) =>
            $query->whereRaw('LOWER(translated_value) LIKE ?', ['%' . mb_strtolower($search) . '%']));
    }

    public function scopeSort($query, Sort $sort = null)
    {
        // return $query->when($sort, fn ($query) 
        //     => $query->orderBy($sort->orderBy(), $sort->type())
        // );

        return $sort?->query($query);
    }
}