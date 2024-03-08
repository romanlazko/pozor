<?php

namespace App\Livewire\Profile;

use App\Models\Marketplace\MarketplaceAnnouncement;
use App\Models\RealEstate\RealEstateAnnouncement;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('layouts.user')]

class Announcements extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $filter = 'all';

    public function render()
    {
        $marketplaceAnnouncements = auth()->user()->marketplaceAnnouncements;
        $realEstateAnnouncements = auth()->user()->realEstateAnnouncements;

        $allAnnouncements = $marketplaceAnnouncements->concat($realEstateAnnouncements)
            ->sortByDesc('created_at')
            ->filter(function ($announcement) {
                if ($this->filter != 'all') {
                    if ($this->filter == 'marketplace') {
                        return $announcement instanceof MarketplaceAnnouncement;
                    }
                    if ($this->filter == 'real_estate') {
                        return $announcement instanceof RealEstateAnnouncement;
                    }
                }
                return $announcement;
            });

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $allAnnouncements->slice(($currentPage - 1) * $perPage, $perPage);

        $paginator = new LengthAwarePaginator($currentItems, $allAnnouncements->count(), $perPage, $currentPage);

        return view('livewire.profile.announcements', [
            'announcements' => $paginator,
        ]);
    }

    // public function resetPage()
    // {
    //     $this->resetPage();
    // }
}
