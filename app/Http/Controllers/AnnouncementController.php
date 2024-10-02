<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Announcement;
use App\View\Models\Announcement\SearchViewModel;

class AnnouncementController extends Controller
{
    public function index(SearchRequest $request)
    {
        $viewModel = new SearchViewModel($request);

        return view('announcement.index', [
            'announcements' => $viewModel->getAnnouncements(),
            'categories' => $viewModel->getCategories(),
            'category' => $viewModel->getCategory(),
            'sortableAttributes' => $viewModel->getSortableAttributes(),
            'paginator' => $viewModel->getPaginator(),
            'request' => $request,
        ]);
    }

    public function search(SearchRequest $request)
    {
        return redirect()->route('announcement.index', [
            'category' => $request->route('category'),
            'data'   => $request->serializedData(),
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
