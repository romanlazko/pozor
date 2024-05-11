<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Announcement;
use App\Models\Attribute;
use App\Models\Category;
use Igaster\LaravelCities\Geo;
use Illuminate\Http\Request;
use Session;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $data = session('announcement_search') ? unserialize(decrypt(urldecode(session('announcement_search')))) : null;

        $category = Category::where('slug', $request->category)->first();

        $categories = Category::where(['parent_id' => $category?->id ?? null])
            ->with('media')
            ->where('is_active', true)
            ->withCount('announcements')
            ->get()
            ->filter(fn ($category) => $category->announcements_count > 0);

        $announcements = Announcement::with('media', 'attributes', 'currency')
            ->isPublished()
            ->categories($category)
            ->features($category, $data['attributes'] ?? null)
            ->price($data['current_price'] ?? null)
            ->search($data['search'] ?? null)
            ->paginate(30)->withQueryString();

        return view('announcement.index', compact('announcements', 'categories', 'category', 'data'));
    }

    public function show(Announcement $announcement)
    {
        if (!$announcement->status->isPublished() AND $announcement->user->id != auth()->id()) {
            abort(404);
        }
        
        $announcements = Announcement::with('attributes', 'currency', 'media')
            ->isPublished()
            ->whereHas('categories', function ($query) use ($announcement) {
                return $query->where('category_id', $announcement->categories->last()->id);
            })
            ->orderByDesc('created_at')
            ->limit(12)
            ->get()
            ->whereNotIn('id', $announcement->id);

        return view('announcement.show', compact('announcement', 'announcements'));
    }

    public function create()
    {
        return view('announcement.create');
    }

    // public function edit(Announcement $announcement)
    // {
    //     return view('announcement.edit', compact('announcement'));
    // }

    // public function update(Request $request, Announcement $announcement)
    // {
    //     if ($request->has('discount')) {
    //         $announcement->discount($request->new_price);
    //     }

    //     if ($request->has('indicate_availability')) {
    //         $announcement->indicateAvailability(auth()->id());
    //     }

    //     if ($request->has('sold')) {
    //         $announcement->sold(auth()->id());
    //     }



    //     return back();
    // }

    public function delete(Announcement $announcement)
    {
        $announcement->delete();

        return back();
    }
}
