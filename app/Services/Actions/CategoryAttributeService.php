<?php 

namespace App\Services\Actions;

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryAttributeService
{
    public function forFilter(Category|null $category)
    {
        $cacheKey = ($category?->slug ?? 'default') . '_filter_attributes';

        $categories = $category?->getParentsAndSelf()->pluck('id')->toArray();

        return Cache::remember($cacheKey, config('cache.ttl'), function () use ($categories) {
            return $this->getAttributesByCategories($categories)
                ->load('filterSection:id,order_number,alternames');
        });
    }

    public function forSorting(Category|null $category)
    {
        $cacheKey = ($category?->slug ?? 'default') . '_sorting_attributes';

        $categories = $category?->getParentsAndSelf()->pluck('id')->toArray();

        return Cache::remember($cacheKey, config('cache.ttl'), function () use ($categories) {
            return $this->getAttributesByCategories($categories)
                ->where('is_sortable');
        });
    }

    public function forCreate($categories)
    {
        $cacheKey = implode('_', $categories) . '_create_attributes';

        return Cache::remember($cacheKey, config('cache.ttl'), function () use ($categories) {
            return $this->getAttributesByCategories($categories)
                ->load('createSection:id,order_number,alternames');
        });
    }

    public function forShow(Category $category, $categories)
    {
        $cacheKey = ($category?->slug ?? 'default') . '_show_attributes';

        return Cache::remember($cacheKey, config('cache.ttl'), function () use ($categories) {
            return Attribute::with('attribute_options:id,alternames,attribute_id,is_default,is_null', 'showSection:id,order_number')
            // ->select('id', 'name', 'is_feature', 'visible', 'filter_layout', 'alterlabels', 'altersuffixes')
                
                ->whereHas('categories', fn (Builder $query) => 
                    $query->whereIn('category_id', $categories)
                )
                ->get();
        });
    }

    public function getAttributesByCategories(array|null $categories)
    {
        return Attribute::with('attribute_options:id,alternames,attribute_id,is_default,is_null')
            ->when(!$categories, fn ($query) => $query->where('always_required', true))
            ->when($categories, fn ($query) => 
                $query->whereHas('categories', fn (Builder $query) => 
                    $query->whereIn('category_id', $categories)
                )
            )
            ->get();
    }
}