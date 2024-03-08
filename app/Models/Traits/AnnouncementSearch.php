<?php

namespace App\Models\Traits;

use App\Enums\Filter;
use App\Jobs\PublishAnnouncementJob;
use Exception;

trait AnnouncementSearch
{
    public function scopeSearch($query, $search, $search_in_caption = false)
    {
        if ($search) {
            return $query->where(function ($query) use ($search, $search_in_caption) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->when($search_in_caption, function ($query) use ($search) {
                        $query->orWhere('caption', 'like', '%' . $search . '%');
                    });
            });
        }
        return $query;
    }

    public function scopePriceRange($query, ?string $minPrice, ?string $maxPrice)
    {
        return $query->when($minPrice && $maxPrice, function ($query) use ($minPrice, $maxPrice) {
            return $query->whereBetween('price', [$minPrice, $maxPrice]);
        })
        ->when($minPrice && !$maxPrice, function ($query) use ($minPrice) {
            return $query->where('price', '>=', $minPrice);
        })
        ->when(!$minPrice && $maxPrice, function ($query) use ($maxPrice) {
            return $query->where('price', '<=', $maxPrice);
        });
    }

    public function scopeCondition($query, array|null $condition)
    {
        if ($condition) {
            if (!empty($condition)) {
                return $query->whereIn('condition', $condition);
            }
        }
        return $query;
    }

    public function scopeCategory($query, int|null $category)
    {
        if ($category) {
            return $query->where('category_id', $category);
        }
        return $query;
    }

    public function scopeSubCategories($query, array|string|null $subcategories)
    {
        if ($subcategories) {
            if (is_array($subcategories) AND !empty($subcategories)) {
                return $query->whereIn('subcategory_id', $subcategories);
            }
            else if (!is_array($subcategories) AND !is_null($subcategories)) {
                return $query->where('subcategory_id', $subcategories);
            }
        }
        return $query;
    }

    public function scopeType($query, string|null $type)
    {
        if ($type) {
            if (!empty($type)) {
                return $query->where('type', $type);
            }
        }
        return $query;
    }

    public function scopeConfiguration($query, array|null $configurations)
    {
        if ($configurations) {
            if (!empty($configurations)) {
                return $query->whereIn('configuration_id', $configurations);
            }
        }
        return $query;
    }

    public function scopeSquareMetersRange($query, ?string $minSquareMeters, ?string $maxSquareMeters)
    {
        return $query->when($minSquareMeters && $maxSquareMeters, function ($query) use ($minSquareMeters, $maxSquareMeters) {
            return $query->whereBetween('square_meters', [$minSquareMeters, $maxSquareMeters]);
        })
        ->when($minSquareMeters && !$maxSquareMeters, function ($query) use ($minSquareMeters) {
            return $query->where('square_meters', '>=', $minSquareMeters);
        })
        ->when(!$minSquareMeters && $maxSquareMeters, function ($query) use ($maxSquareMeters) {
            return $query->where('square_meters', '<=', $maxSquareMeters);
        });
    }

    public function scopeFloorRange($query, ?string $minFlore, ?string $maxFlore)
    {
        return $query->when($minFlore && $maxFlore, function ($query) use ($minFlore, $maxFlore) {
            return $query->whereBetween('floor', [$minFlore, $maxFlore]);
        })
        ->when($minFlore && !$maxFlore, function ($query) use ($minFlore) {
            return $query->where('floor', '>=', $minFlore);
        })
        ->when(!$minFlore && $maxFlore, function ($query) use ($maxFlore) {
            return $query->where('floor', '<=', $maxFlore);
        });
    }

    public function scopeAdditionalSpaces($query, array|null $additional_spaces)
    {
        return $query->when($additional_spaces && count($additional_spaces) > 0, function ($query) use ($additional_spaces) {
            return $query->where(function ($query) use ($additional_spaces) {
                foreach ($additional_spaces as $space) {
                    $query->orWhereJsonContains('additional_spaces', intval($space));
                }
            });
        });
    }

    public function scopeFilter($query, ?string $filter)
    {
        return $query->when($filter === Filter::mostExpensive->name, function ($query) {
            $query->orderBy('price', 'desc');
        })
        ->when($filter === Filter::cheapest->name, function ($query) {
            $query->orderBy('price', 'asc');
        })
        ->when($filter === Filter::newest->name, function ($query) {
            $query->orderBy('created_at', 'desc');
        })
        ->when($filter === Filter::oldest->name, function ($query) {
            $query->orderBy('created_at', 'asc');
        });
    }

    public function scopeLocation($query, ?array $location, ?int $radius)
    {
        return $query->when($location, function ($query) use ($location, $radius) {
            return $radius
                ? $query->radius($location['lat'], $location['long'], $radius)
                : $query->whereJsonContains('location->name', $location['name']);
        });
    }

    public function scopeEquipment($query, ?array $equipment)
    {
        if ($equipment) {
            if (!empty($equipment)) {
                return $query->whereIn('equipment', $equipment);
            }
        }
        return $query;
    }
}