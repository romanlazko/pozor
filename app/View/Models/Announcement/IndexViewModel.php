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

class IndexViewModel
{
    public $features = null;

    private $filterQueries = 0;

    public function __construct()
    {
    }

    public function categories()
    {
        return Cache::remember('all_categories', config('cache.ttl'), function () {
            return Category::whereNull('parent_id')
                ->isActive()
                ->get()
                ->load('media');
        });
    }

    public function announcements()
    {
        return $this->getAnnouncementsQuery()
            ->paginate(30)
            ->withQueryString();
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
            ->isPublished();
    }
}