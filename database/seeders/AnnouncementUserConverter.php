<?php

namespace Database\Seeders;

use App\Bots\pozor_baraholka_bot\Models\BaraholkaAnnouncement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Romanlazko\Telegram\App\DB;
use Romanlazko\Telegram\Models\Bot;

class AnnouncementUserConverter extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bot = Bot::where('id', '5176671917')->first();

        $announcements = BaraholkaAnnouncement::all();

        foreach ($announcements as $announcement) {
            $chat = $bot->chats()->where('chat_id', $announcement->user_id)->first();

            $announcement->update([
                'chat' => $chat->id
            ]);
        }
    }
}