<?php

namespace App\Models\Traits;

use App\AttributeType\AttributeFactory;
use App\Enums\Sort;
use App\Enums\Status;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Geo;
use App\Services\Actions\CategoryAttributeService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

use function JmesPath\search;

trait AnnouncementSearch
{
    public function scopeCategory($query, ?Category $category)
    {
        if (!$category) {
            return $query;
        }

        // return $query->whereHas('categories', fn ($query) 
        //     => $query->where('category_id', $category->id)
        //         ->select('categories.id')
        // );

        return $query->leftJoin('announcement_category', 'announcement_category.announcement_id', '=', 'announcements.id')
            ->where('announcement_category.category_id', $category->id);
    }

    public function scopeGeo($query, $location)
    {
        return $query->whereHas('geo', function ($query) use ($location) {
            $query->radius($location['coordinates']['lat'], $location['coordinates']['lng'], (integer) $location['radius'] == 0 ? 30 : (integer) $location['radius']);
        });
    }

    public function scopeFilter($query, ?Category $category, ?array $attributes)
    {
        if (!$category OR !$attributes) {
            return $query;
        }

        return $query->where(function (Builder $query) use ($category, $attributes) {
            $filterAttributes = (new CategoryAttributeService())->forFilter($category);

            foreach ($filterAttributes as $attribute) {
                AttributeFactory::applySearchQuery($attribute, $attributes, $query);
            }
        });
    }

    public function scopeIsPublished($query)
    {
        return $query->where('current_status', Status::published);
    }

    public function scopeSearch($query, ?string $search = null)
    {
        if (!$search) {
            return $query;
        }
        
        return $query->whereHas('features', fn ($query) =>
            $query->whereRaw('LOWER(translated_value) LIKE ?', ['%' . mb_strtolower($search) . '%']));
    }

    public function scopeSort($query, ?string $sort = null)
    {
        if (!$sort) {
            return $query;
        }

        $sort = explode(':', $sort);
        $attribute_name = $sort[0];
        $direction = $sort[1] ?? 'asc';

        $attribute = Attribute::firstWhere('name', $attribute_name);

        if ($attribute) {
            return AttributeFactory::applySortQuery($attribute, $direction, $query);
        }

        return $query->orderBy($attribute_name, $direction);
    }
}