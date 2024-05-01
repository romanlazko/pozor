<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Announcement;
use App\Models\Attribute;
use App\Models\Category;
use Igaster\LaravelCities\Geo;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::whereNull('parent_id')->where('is_active', true)->whereHas('announcements')->get();
        $announcements = Announcement::with('attributes', 'currency')
            ->whereHas('categories', fn ($query) => $query->whereIn('category_id', $categories->pluck('id')->toArray()))
            ->paginate(50);

        return view('announcement.index', compact('announcements', 'categories'));
    }

    public function search(Category $category, Request $request)
    {
        $data = $request->search ? unserialize(decrypt(urldecode($request->search))) : null;

        $category->load('children');

        $announcements = Announcement::with('attributes', 'currency')
            ->categories($category)
            ->features($category, $data['attributes'] ?? null)
            ->price($data['price'] ?? null)
            ->search($data['search'] ?? null)
            ->paginate(30)->withQueryString();

        return view('announcement.search', compact('announcements', 'data', 'category'));
    }

    public function show(Announcement $announcement)
    {
        $announcements = Announcement::with('attributes', 'currency')
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

    public function edit(Announcement $announcement)
    {
        return view('announcement.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        if ($request->has('discount')) {
            $announcement->discount($request->new_price);
        }

        if ($request->has('indicate_availability')) {
            $announcement->indicateAvailability(auth()->id());
        }

        if ($request->has('sold')) {
            $announcement->sold(auth()->id());
        }



        return back();
    }

    public function delete(Announcement $announcement)
    {
        $announcement->delete();

        return back();
    }
}
