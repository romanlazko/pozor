<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Announcement;
use App\View\Models\Announcement\IndexViewModel;
use App\View\Models\Announcement\SearchViewModel;

class AnnouncementController extends Controller
{
    public function index()
    {
        session()->forget('announcement_search');

        $viewModel = new IndexViewModel();

        return view('announcement.index', [
            'announcements' => $viewModel->announcements(),
            'categories' => $viewModel->categories(),
        ]);
    }

    public function all(SearchRequest $request)
    {
        $viewModel = new SearchViewModel($request);

        $announcements = $viewModel->announcements();

        $paginator = $viewModel->features()->isNotEmpty() ? $viewModel->features() : $announcements;

        return view('announcement.all', [
            'announcements' => $announcements,
            'categories' => $viewModel->categories(),
            'category' => $viewModel->category(),
            'sortableAttributes' => $viewModel->sortableAttributes(),
            'data' => $request->data,
            'paginator' => $paginator,
        ]);
    }

    public function search(SearchRequest $request)
    {
        return redirect()->route('announcement.all', [
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
