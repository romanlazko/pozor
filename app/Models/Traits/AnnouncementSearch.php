<?php

namespace App\Models\Traits;

use App\Enums\Filter;
use App\Enums\Sort;
use App\Enums\Status;
use App\Jobs\PublishAnnouncementJob;
use App\Models\Marketplace\MarketplaceCategory;
use Exception;
use Igaster\LaravelCities\Geo;
use Illuminate\Database\Eloquent\Builder;

trait AnnouncementSearch
{
    public function scopeFilter(Builder $query, $request)
    {
        $query
            ->search($request->search, $request->search_in_caption)
            ->sort($request->sort ?? Sort::newest->name)
            ->priceRange($request->priceMin, $request->priceMax)
            ->condition($request->condition)
            // ->category($request->category)
            ->location($request->location, $request->radius);
    }

    public function scopeIsPublished(Builder $query)
    {
        return $query->where('status', Status::published);
    }
    
    public function scopeSearch(Builder $query, $search, $search_in_caption = false)
    {
        if ($search) {
            $search = '%' . mb_strtolower($search) . '%';

            return $query->where(function (Builder $query) use ($search, $search_in_caption) {
                $query->whereRaw('LOWER(title) LIKE ?', [$search])
                    ->when($search_in_caption, function (Builder $query) use ($search) {
                        $query->orWhereRaw('LOWER(caption) LIKE ?', [$search]);
                    })
                    ->orWhere('keys', 'like', strtolower(str_replace([' ', '.', ':', ';'], '', $search)));
            });
        }
        return $query;
    }

    public function scopePriceRange(Builder $query, ?string $minPrice, ?string $maxPrice)
    {
        return $query->when($minPrice && $maxPrice, function (Builder $query) use ($minPrice, $maxPrice) {
                return $query->whereBetween('price', [$minPrice, $maxPrice]);
            })
            ->when($minPrice && !$maxPrice, function (Builder $query) use ($minPrice) {
                return $query->where('price', '>=', $minPrice);
            })
            ->when(!$minPrice && $maxPrice, function (Builder $query) use ($maxPrice) {
                return $query->where('price', '<=', $maxPrice);
            });
    }

    public function scopeCondition(Builder $query, array|null $condition)
    {
        if ($condition) {
            if (!empty($condition)) {
                return $query->whereIn('condition', $condition);
            }
        }
        return $query;
    }

    // public function scopeCategory(Builder $query, null $category)
    // {
    //     return $query->when($category, function (Builder $query) use ($category) {
    //         return $query->whereIn('category_id', $category?->getChildren()->pluck('id'));
    //     });
    // }

    public function scopeType(Builder $query, string|null $type)
    {
        if ($type AND !empty($type)) {
            return $query->where('type', $type);
        }

        return $query;
    }

    public function scopeConfiguration(Builder $query, array|null $configurations)
    {
        if ($configurations AND !empty($configurations)) {
            return $query->whereIn('configuration_id', $configurations);
        }

        return $query;
    }

    public function scopeSquareMetersRange(Builder $query, ?string $minSquareMeters, ?string $maxSquareMeters)
    {
        return $query->when($minSquareMeters && $maxSquareMeters, function (Builder $query) use ($minSquareMeters, $maxSquareMeters) {
                return $query->whereBetween('square_meters', [$minSquareMeters, $maxSquareMeters]);
            })
            ->when($minSquareMeters && !$maxSquareMeters, function (Builder $query) use ($minSquareMeters) {
                return $query->where('square_meters', '>=', $minSquareMeters);
            })
            ->when(!$minSquareMeters && $maxSquareMeters, function (Builder $query) use ($maxSquareMeters) {
                return $query->where('square_meters', '<=', $maxSquareMeters);
            });
    }

    public function scopeFloorRange(Builder $query, ?string $minFlore, ?string $maxFlore)
    {
        return $query->when($minFlore && $maxFlore, function (Builder $query) use ($minFlore, $maxFlore) {
                return $query->whereBetween('floor', [$minFlore, $maxFlore]);
            })
            ->when($minFlore && !$maxFlore, function (Builder $query) use ($minFlore) {
                return $query->where('floor', '>=', $minFlore);
            })
            ->when(!$minFlore && $maxFlore, function (Builder $query) use ($maxFlore) {
                return $query->where('floor', '<=', $maxFlore);
            });
    }

    public function scopeAdditionalSpaces(Builder $query, array|null $additional_spaces)
    {
        return $query->when($additional_spaces && count($additional_spaces) > 0, function (Builder $query) use ($additional_spaces) {
            return $query->where(function (Builder $query) use ($additional_spaces) {
                foreach ($additional_spaces as $space) {
                    $query->orWhereJsonContains('additional_spaces', intval($space));
                }
            });
        });
    }

    public function scopeSort(Builder $query, ?string $sort)
    {
        return $query->when($sort === Sort::mostExpensive->name, function (Builder $query) {
                $query->orderBy('price', 'desc');
            })
            ->when($sort === Sort::cheapest->name, function (Builder $query) {
                $query->orderBy('price', 'asc');
            })
            ->when($sort === Sort::newest->name, function (Builder $query) {
                $query->orderBy('created_at', 'desc');
            })
            ->when($sort === Sort::oldest->name, function (Builder $query) {
                $query->orderBy('created_at', 'asc');
            });
    }

    public function scopeLocation(Builder $query, ?int $location, ?int $radius)
    {
        $location = Geo::find($location)?->toArray();
        return $query->when($location, function (Builder $query) use ($location, $radius) {
            return $radius
                ? $query->radius($location['lat'], $location['long'], $radius)
                : $query->whereJsonContains('location->name', $location['name']);
        });
    }

    public function scopeEquipment(Builder $query, ?array $equipment)
    {
        if ($equipment AND !empty($equipment)) {
            return $query->whereIn('equipment', $equipment);
        }
        return $query;
    }
}