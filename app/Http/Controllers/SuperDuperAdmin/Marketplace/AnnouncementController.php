<?php

namespace App\Http\Controllers\SuperDuperAdmin\Marketplace;

use App\Enums\Filter;
use App\Enums\Status;
use App\Events\ModerationPassedMarketplaceAnnouncement;
use App\Http\Controllers\Controller;
use App\Models\Marketplace\MarketplaceAnnouncement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $announcements = MarketplaceAnnouncement::search($request->search ?? null)
            ->where('status', $request->status ?? Status::await_moderation)
            ->filter($request->filter ?? Filter::newest->name)
            ->paginate(100);

        return view('admin.marketplace.index', compact(
            'announcements'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MarketplaceAnnouncement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MarketplaceAnnouncement $announcement)
    {
        return view('admin.marketplace.edit', compact(
            'marketplaceAnnouncement'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MarketplaceAnnouncement $announcement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MarketplaceAnnouncement $announcement)
    {
        //
    }

    public function approve(MarketplaceAnnouncement $announcement)
    {
        $announcement->moderationPassed(auth()->user()->name);

        return back();
    }

    public function stop_publication(MarketplaceAnnouncement $announcement)
    {
        $announcement->moderate(auth()->user()->name);

        return back();
    }

    public function publish(MarketplaceAnnouncement $announcement)
    {
        $announcement->publish(auth()->user()->name);

        return back();
    }

    public function reject(MarketplaceAnnouncement $announcement)
    {
        $announcement->rejected(auth()->user()->name);

        return back();
    }
}
