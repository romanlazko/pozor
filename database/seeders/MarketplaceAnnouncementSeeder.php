<?php

namespace Database\Seeders;

use App\Models\Marketplace\MarketplaceAnnouncement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarketplaceAnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MarketplaceAnnouncement::factory(1000)->create();
    }
}
