<?php

namespace App\Http\Controllers;

use App\Enums\Sort;
use App\Enums\Status;
use App\Models\Announcement;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::whereNull('parent_id')
                ->with('media')
                ->isActive()
                ->withCount(['announcements' => fn ($query) => $query->isPublished()])
                ->get();

        // $categories = $categories->filter(fn ($category) => $category->announcements_count > 0)->sortByDesc('announcements_count');

        $announcements = Announcement::with([
                'media',
                'features:id,announcement_id,attribute_id,attribute_option_id,translated_value',
                'features.attribute:id,name,alterlabels,order_number,searchable,is_feature,altersuffixes,create_type',
                'features.attribute_option:id,alternames',
                'user',
                'geo',
                'userVotes',
                'currentStatus'
            ])
            ->select('announcements.*')
            ->isPublished()
            ->orderBy('created_at', 'desc')
            ->paginate(30)->withQueryString();

        return view('announcement.index', compact('announcements', 'categories'));
    }

    public function search(Request $request)
    {
        $data = session('announcement_search') ? unserialize(decrypt(urldecode(session('announcement_search')))) : null;

        // dump($data);


        $category = Category::select('id', 'alternames', 'slug', 'parent_id', 'is_active')
            ->where('slug', $request->category)
            ->isActive()
            ->withCount(['announcements' => fn ($query) => $query->isPublished()])
            ->with([
                'children' => fn ($query) => 
                    $query->isActive()->with('media')->withCount(['announcements' => fn ($query) => $query->isPublished()]), 
                'siblings' => fn ($query) => 
                    $query->isActive()->with('media')->withCount(['announcements' => fn ($query) => $query->isPublished()]), 
            ])
            ->first();

        $categories = ($category?->children->isNotEmpty() ? $category->children : null) 
            ?? ($category?->siblings->isNotEmpty() ? $category->siblings : null) 
            ?? Category::whereNull('parent_id')
                ->with('media')
                ->isActive()
                ->withCount(['announcements' => fn ($query) => $query->isPublished()])
                ->get();

        // $categories = $categories->filter(fn ($category) => $category->announcements_count > 0)->sortByDesc('announcements_count');

        $announcements = Announcement::with([
                'media',
                'features:id,announcement_id,attribute_id,attribute_option_id,translated_value',
                'features.attribute:id,name,alterlabels,order_number,searchable,is_feature,altersuffixes,create_type',
                'features.attribute_option:id,alternames',
                'user',
                'geo',
                'userVotes',
                'currentStatus'
            ])
            ->select('announcements.*')
            ->isPublished()
            ->category($category)
            ->features($category, $data['attributes'] ?? null)
            ->sort(Sort::tryFrom($data['sort'] ?? 'newest'))
            ->paginate(30)->withQueryString();

        return view('announcement.index', compact('announcements', 'category', 'categories', 'data'));
    }

    public function show(Announcement $announcement)
    {
        $announcement->load([
            'user.media',
            'userVotes',
            'media',
            'geo',
            'currentStatus',
            'features:announcement_id,attribute_id,attribute_option_id,translated_value', 
            'features.attribute:id,name,alterlabels,order_number,attribute_section_id,is_feature,altersuffixes,create_type',
            'features.attribute_option:id,alternames',
            'features.attribute.section:id,alternames,order_number', 
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

    public function telegram_create(Request $request)
    {
        $user = User::where('email', $request->email)->where('telegram_chat_id', $request->telegram_chat_id)->first();

        if (!$user) {
            dd('User not found');
        }

        Auth::login($user);

        return view('announcement.telegram-create');
    }

    public function wishlist()
    {
        $announcements = auth()->user()->wishlist()->isPublished()
            ->get();

        return view('announcement.wishlist', compact('announcements'));
    }
}
