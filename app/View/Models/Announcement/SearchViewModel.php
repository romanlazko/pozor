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

    private $filterQueries = 0;

    public function __construct(public SearchRequest $request)
    {
    }

    public function announcements()
    {
        return $this->getAnnouncementsQuery()
            ->when($this->features()->isNotEmpty(), fn ($query) => 
                $query->whereIn('announcements.id', $this->features()->pluck('announcement_id'))
                    ->get()
            )
            ->when($this->features()->isEmpty(), fn ($query) => 
                $query->category($this->category())
                    ->isPublished()
                    ->paginate(30)
                    ->withQueryString()
            );
    }

    public function category(): ?Category
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

    public function categories()
    {
        return Cache::remember($this->category()?->slug.'_categories', config('cache.ttl'), function () {
            if ($children = $this->category()?->children->where('is_active', true) AND $children->isNotEmpty()) {
                return $children->load('media');
            }

            if ($siblings = $this->category()?->siblings->where('is_active', true) AND $siblings->isNotEmpty()) {
                return $siblings->load('media');
            }

            return Category::whereNull('parent_id')
                ->isActive()
                ->get()
                ->load('media');
        });
    }

    public function sortableAttributes()
    {
        return (new CategoryAttributeService())->forSorting($this->category());
    }

    private function getAnnouncementsQuery()
    {
        $title_price_attributes = Attribute::whereHas('showSection', fn ($query) => 
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
            ->sort($this->request->data['sort']);
    }

    public function features()
    {
        if (!$this->features) {
            $this->features = $this->getFeatures();
        }

        return $this->features;
    }

    public function paginator() 
    {
        if ($this->features()->isNotEmpty()) {
            return $this->features();
        }

        return $this->announcements();
    }

    public function getFeatures() 
    {
        $filters = $this->request->data['filters']['attributes'] ?? null;
        $search = $this->request->data['search'] ?? null;

        if (!$filters AND !$search) {
            return collect([]);
        }

        return Feature::select('announcement_id')->groupBy('announcement_id')
            ->where(function ($query) use ($filters) {
                $filterAttributes = (new CategoryAttributeService())->forFilter($this->category());

                foreach ($filterAttributes as $attribute) {
                    $query->orWhere(function($query) use ($attribute, $filters) {
                        if (AttributeFactory::applyAlternativeSearchQuery($attribute, $filters, $query) instanceof Builder) {
                            $this->filterQueries++;
                        }
                    });
                }
                
                return $query;
            })
            
            ->when($search, fn ($query) =>
                $query->orWhere(fn ($query) => 
                    $query->whereRaw('LOWER(translated_value) LIKE ?', ['%' . mb_strtolower($search) . '%'])
                        ->orWhereHas('attribute_option', fn ($query) => 
                            $query->whereRaw('LOWER(alternames) LIKE ?', ['%' . mb_strtolower($search) . '%'])
                        )
                )
            )
            ->whereHas('announcement', fn ($query) => $query->category($this->category())->isPublished())
            ->havingRaw('COUNT(DISTINCT attribute_id) = '. $this->filterQueries)
            ->paginate(30)
            ->withQueryString();
    }
}