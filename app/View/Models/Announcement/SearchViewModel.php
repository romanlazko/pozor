<?php 

namespace App\View\Models\Announcement;

use App\AttributeType\AttributeFactory;
use App\Http\Requests\SearchRequest;
use App\Models\Announcement;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Feature;
use App\Services\Actions\CategoryAttributeService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;

class SearchViewModel
{
    public $features = null;

    public $category = null;

    public $categories = null;

    public $announcements = null;

    public $sortableAttributes = null;

    private $filterQueries = 0;

    public function __construct(public SearchRequest $request)
    {
        $this->category = $this->category();
        $this->categories = $this->categories();
        $this->features = $this->features();
        $this->announcements = $this->announcements();
        $this->sortableAttributes = $this->sortableAttributes();
    }

    private function announcements()
    {
        $title_price_attributes = Attribute::whereHas('group', fn ($query) => 
            $query->whereIn('slug', ['title', 'price'])
        )
        ->pluck('id');

        return Announcement::with([
                'media',
                'features' => fn ($query) => 
                    $query->with([
                            'attribute_option:id,alternames',
                        ])
                        ->whereIn('attribute_id', $title_price_attributes),
                'geo',
                'userVotes',
            ])
            ->select('announcements.id', 'announcements.slug', 'announcements.geo_id', 'announcements.created_at')
            ->sort($this->request->sort)
            ->whereIn('announcements.id', $this->features->pluck('announcement_id'))
            ->get();
    }

    private function category(): ?Category
    {
        if (!$this->request->route('category')) {
            return null;
        }

        return Cache::remember($this->request->route('category').'_category', config('cache.ttl'), function () {
            return Category::select('id', 'slug', 'parent_id', 'is_active', 'alternames')
                ->where('slug', $this->request->route('category'))
                ->isActive()
                ->first();
        });
    }

    private function categories()
    {
        return Cache::remember($this->category?->slug.'_categories', config('cache.ttl'), function () {
            if ($children = $this->category?->children->where('is_active', true) AND $children->isNotEmpty()) {
                return $children->load('media');
            }

            if ($siblings = $this->category?->siblings->where('is_active', true) AND $siblings->isNotEmpty()) {
                return $siblings->load('media');
            }

            return Category::whereNull('parent_id')
                ->isActive()
                ->get()
                ->load('media');
        });
    }

    private function sortableAttributes()
    {
        return (new CategoryAttributeService())->forSorting($this->category);
    }

    private function features() 
    {
        $filters = $this->request->filters['attributes'] ?? null;
        $search = $this->request->search;
        $location = $this->request->location;

        return Feature::select('announcement_id')->groupBy('announcement_id')
            ->when($filters, fn ($query) => 
                $query->where(function ($query) use ($filters) {
                    $filterAttributes = (new CategoryAttributeService())->forFilter($this->category);
    
                    foreach ($filterAttributes as $attribute) {
                        $query->orWhere(function($query) use ($attribute, $filters) {
                            if (AttributeFactory::applyAlternativeSearchQuery($attribute, $filters, $query) instanceof Builder) {
                                $this->filterQueries++;
                            }
                        });
                    }
                    
                    return $query;
                })
            )
        
            ->when($search, fn ($query) =>
                $query->orWhere(fn ($query) => 
                    $query->whereRaw('LOWER(translated_value) LIKE ?', ['%' . mb_strtolower($search) . '%'])
                        ->orWhereHas('attribute_option', fn ($query) => 
                            $query->whereRaw('LOWER(alternames) LIKE ?', ['%' . mb_strtolower($search) . '%'])
                        )
                )
            )

            ->whereHas('announcement', fn ($query) => 
                $query->category($this->category)
                    ->isPublished()
                    ->when($location, fn ($query) => $query->geo($location))
            )

            ->when($filters, fn ($query) => $query->havingRaw('COUNT(DISTINCT attribute_id) = '. $this->filterQueries + ($search ? 1 : 0)))
            ->paginate(30)
            ->withQueryString();
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function getSortableAttributes()
    {
        return $this->sortableAttributes;
    }

    public function getAnnouncements()
    {
        return $this->announcements;
    }

    public function getFeatures()
    {
        return $this->features;
    }

    public function getPaginator()
    {
        return $this->features;
    }
}