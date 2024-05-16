<?php

namespace App\Http\Controllers;

use App\Enums\Sort;
use App\Enums\Status;
use App\Models\Announcement;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\User;
use Igaster\LaravelCities\Geo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $data = session('announcement_search') ? unserialize(decrypt(urldecode(session('announcement_search')))) : null;

        $category = Category::where('slug', $request->category)->select('id', 'name', 'alternames', 'slug', 'parent_id')->first();

        $categories = Category::where(['parent_id' => $category?->id ?? null])
            ->select('id', 'name', 'alternames', 'slug')
            ->with('media')
            ->where('is_active', true)
            ->withCount('announcements')
            ->get()
            ->filter(fn ($category) => $category->announcements_count > 0);

        $announcements = Announcement::with('media', 'attributes:id', 'currency:id,name')
            ->isPublished()
            ->categories($category)
            ->sort(Sort::tryFrom($data['sort'] ?? 'newest'))
            ->features($category, $data['attributes'] ?? null)
            ->price($data['current_price'] ?? null)
            ->search($data['search'] ?? null, $data['search_in_description'] ?? false)
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

    public function telegram_create(Request $request)
    {
        $user = User::where('email', $request->email)->where('telegram_chat_id', $request->telegram_chat_id)->first();

        if (!$user) {
            dd('User not found');
        }

        if (! Auth::login($user))
        {
            dd('Auth error');
        }

        return view('announcement.telegram-create');
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
