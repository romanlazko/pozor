<?php

namespace Database\Seeders;

use App\Models\RealEstate\RealEstateAnnouncement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RealEstateAnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // RealEstateAnnouncement::truncate();
        RealEstateAnnouncement::factory(1000)->create();
    }
}
