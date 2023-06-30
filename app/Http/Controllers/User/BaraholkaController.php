<?php

namespace App\Http\Controllers\User;

use App\Bots\pozor_baraholka_bot\Models\BaraholkaAnnouncement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Romanlazko\Telegram\App\Telegram;
use Romanlazko\Telegram\Models\Bot;

class BaraholkaController extends Controller
{
    private $telegram; 

    public function __construct()
    {
        $this->telegram = new Telegram("5176671917:AAG93hdYLK2CmaJtuvCWSsSnZ9jYyLUe6RQ");
    }
    public function __invoke(Request $request)
    {
        $search = strtolower($request->search);
        $type = strtolower($request->type);
        $category = strtolower($request->category);
        $city = strtolower($request->city);

        $announcements = BaraholkaAnnouncement::orderByDesc('created_at')
            ->where('status', 'published')
            ->when(!empty($request->input('search')), function($query) use($search) {
                return $query->where(function ($query) use ($search) {
                    $query->whereRaw('LOWER(title) LIKE ?', ['%' . $search . '%'])
                        ->orWhereRaw('LOWER(caption) LIKE ?', ['%' . $search . '%'])
                        ->orWhereRaw('LOWER(category) LIKE ?', ['%' . $search . '%']);
                });
            })
            ->when(!empty($request->input('type')), function($query) use($type) {
                return $query->where(function ($query) use ($type) {
                    $query->whereRaw('LOWER(type) LIKE ?', ['%' . $type . '%']);
                });
            })
            ->when(!empty($request->input('city')), function($query) use($city) {
                return $query->where(function ($query) use ($city) {
                    $query->whereRaw('LOWER(city) LIKE ?', ['%' . $city . '%']);
                });
            })
            ->when(!empty($request->input('category')), function($query) use($category) {
                return $query->where(function ($query) use ($category) {
                    $query->whereRaw('LOWER(category) LIKE ?', ['%' . $category . '%']);
                });
            })
            ->paginate(21);

            $announcements_collection = $announcements->map(function ($announcement) {
                $announcement->photos->take(9)->map(function ($photo) {
                    return $photo->url = Cache::remember($photo->file_id, 1000, function () use ($photo) {
                        return file_exists(public_path($photo->file_id))
                            ? asset($photo->file_id) 
                            : file_get_contents($this->telegram::getPhoto(['file_id' => $photo->file_id]));
                    });
                });
                return $announcement;
            })
            ->map(function ($announcement) {
                $announcement->chat = $announcement->chat()->first();
                return $announcement;
            });

        return view('user.baraholka.index', compact(
            'announcements',
            'announcements_collection',
        ));
    }
}
