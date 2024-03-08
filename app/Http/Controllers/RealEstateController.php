<?php

namespace App\Http\Controllers;

use App\Models\RealEstate\RealEstateAnnouncement;
use Illuminate\Http\Request;

class RealEstateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('real-estate.index');
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
    public function show(RealEstateAnnouncement $announcement)
    {
        if ($announcement->status == 'published') {
            return view('real-estate.show', ['announcement' => $announcement]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RealEstateAnnouncement $realEstateAnnouncement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RealEstateAnnouncement $realEstateAnnouncement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RealEstateAnnouncement $realEstateAnnouncement)
    {
        //
    }
}
