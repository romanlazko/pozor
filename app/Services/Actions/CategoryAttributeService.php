<?php 

namespace App\Services\Actions;

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryAttributeService
{
    public function forFilter(Category $category)
    {
        $cacheKey = ($category?->slug ?? 'default') . '_filter_attributes';

        $categories = $category?->getParentsAndSelf()->pluck('id')->toArray();

        return Cache::remember($cacheKey, config('cache.ttl'), function () use ($categories) {
            return Attribute::with('attribute_options:id,alternames,attribute_id,is_default,is_null', 'filterSection:id,order_number')
            // ->select('id', 'name', 'is_feature', 'visible', 'filter_layout', 'alterlabels', 'altersuffixes')
                
                ->whereHas('categories', fn (Builder $query) => 
                    $query->whereIn('category_id', $categories)
                )
                ->get();
        });
    }

    public function forSearch(Category $category)
    {
        $cacheKey = ($category?->slug ?? 'default') . '_search_attributes';

        $categories = $category?->getParentsAndSelf()->pluck('id')->toArray();
        
        return Cache::remember($cacheKey, config('cache.ttl'), function () use ($categories) {
            return Attribute::with('attribute_options:id,alternames,attribute_id,is_default,is_null', 'filterSection:id,order_number')
            // ->select('id', 'name', 'is_feature', 'visible', 'filter_layout', 'alterlabels', 'altersuffixes')
                
                ->whereHas('categories', fn (Builder $query) => 
                    $query->whereIn('category_id', $categories)
                )
                ->get();
        });
    }

    public function forCreate(Category $category, $categories)
    {
        $cacheKey = implode('_', $this->data['categories']) . '_create_attributes';

        return Cache::remember($cacheKey, config('cache.ttl'), function () use ($categories) {
            return Attribute::with([
                    'attribute_options' => function (HasMany $query) {
                        return $query->select(
                            'attribute_id',
                            'id',
                            'alternames',
                            'is_default',
                            'is_null'
                        )->whereNot('is_null', true);
                    },
                    'createSection:id,order_number,alternames'
                ])
                ->whereHas('categories', fn (Builder $query) => $query->whereIn('category_id', $categories))
                ->get();
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
}