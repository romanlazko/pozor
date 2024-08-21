<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Announcement;
use App\Models\Category;
use App\Services\Actions\CategoryAttributeService;
use Illuminate\Support\Facades\Cache;

class AnnouncementController extends Controller
{
    public function index(SearchRequest $request, CategoryAttributeService $categoryAttributeService)
    {
        $category = Category::select('id', 'slug', 'parent_id', 'is_active')
            ->where('slug', $request->route('category'))
            ->isActive()
            ->first();

        $categories = Cache::remember($category?->slug.'_categories', config('cache.ttl'), function () use ($category) {
                return ($category?->children->isNotEmpty() ? $category->children->load('media') : null)
                    ?? ($category?->siblings->isNotEmpty() ? $category->siblings->load('media') : null)
                    ?? Category::whereNull('parent_id')
                        ->isActive()
                        ->get()
                        ->load('media');
            })
            ->loadCount(['announcements' => fn ($query) => $query->isPublished()])
            // ->filter(fn ($category) => $category->announcements_count > 0 AND $category->is_active)
            ->sortByDesc('announcements_count');
        
        $searchAttributes = $category ? $categoryAttributeService->forSearch($category) : collect([]);

        $announcements = Announcement::with([
                'media',
                'features' => fn ($query) => $query->whereHas('attribute', fn ($query) => $query->whereHas('showSection', fn ($query) => $query->whereIn('slug', ['title', 'price']))),
                'features.attribute_option:id,alternames',
                'geo',
                'userVotes',
            ])
            ->select('announcements.*')
            ->isPublished()
            ->category($category)
            ->features($searchAttributes, $request->data['filters']['attributes'] ?? null)
            ->sort($request->data['sort'])
            ->search($request->data['search'])
            ->paginate(30)->withQueryString();

        return view('announcement.index', [
            'announcements' => $announcements,
            'categories' => $categories,
            'category' => $category,
            'data' => $request->data,
        ]);
    }

    public function search(SearchRequest $request)
    {
        return redirect()->route('announcement.index', [
            'category' => $request->route('category'), 
            'data' => $request->serializedData()
        ]);
    }

    public function show(Announcement $announcement)
    {
        $announcement->load([
            'user.media',
            'userVotes',
            'media',
            'geo',
            'features:announcement_id,attribute_id,attribute_option_id,translated_value', 
            'features.attribute:id,name,alterlabels,is_feature,altersuffixes,show_layout',
            'features.attribute_option:id,alternames',
            'features.attribute.showSection:id,alternames,order_number,slug',
            'categories:id,slug,alternames',
        ]);

        if (!$announcement->status->isPublished() AND $announcement->user?->id != auth()->id()) {
            abort(404);
        }

        $similar_announcements = [];
        $user_announcements = [];

        // $announcement->user->isPartner()
        // if (false) {
        //     $user_announcements = Announcement::isPublished()
        //         ->limit(12)
        //         ->whereNot('id', $announcement->id)
        //         ->where('user_id', $announcement->user?->id)
        //         ->get();
        // }
        // else {
        //     $similar_announcements = Announcement::select('announcements.*')
        //         ->join('announcement_category', 'announcements.id', '=', 'announcement_category.announcement_id')
        //         ->where('announcement_category.category_id', $announcement->categories?->last()->id)
        //         ->isPublished()
        //         ->with('media', 'features.attribute_option','user','user.media')
        //         ->orderByDesc('created_at')
        //         ->whereNot('announcements.id', $announcement->id)
        //         ->limit(12)
        //         ->get();
        // }

        return view('announcement.show', compact('announcement', 'similar_announcements', 'user_announcements'));
    }

    public function create()
    {
        return view('announcement.create');
    }

    public function wishlist()
    {
        $announcements = auth()->user()->wishlist()->isPublished()->latest()
            ->paginate(30)->withQueryString();

        return view('announcement.wishlist', compact('announcements'));
    }
}
