<?php
namespace App\Http\Controllers\SuperDuperAdmin\Telegram;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Romanlazko\Telegram\Http\Requests\AdvertisementRequest;
use Romanlazko\Telegram\Models\Advertisement;
use Romanlazko\Telegram\Models\TelegramBot;

class TelegramAdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TelegramBot $telegram_bot)
    {
        $advertisements = Advertisement::where('bot_id', $telegram_bot->getBotId())->get();

        return view('admin.telegram.advertisement.index', compact(
            'advertisements'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.telegram.advertisement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvertisementRequest $request, TelegramBot $telegram_bot)
    {
        $images = [];

        $advertisement = Advertisement::create([
            'telegram_bot_id' => $telegram_bot->id,
            ...Arr::except($request->validated(), ['images'])
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = ['url' => Storage::url($image->store('public/advertisements'))];
            }
            $advertisement->images()->createMany(
                $images
            );
        }

        return redirect()->route('admin.telegram_bot.advertisement.index')->with([
            'ok' => true,
            'description' => "Advertisement succesfuly created"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TelegramBot $telegram_bot, Advertisement $advertisement)
    {
        return view('admin.telegram_bot.advertisement.edit', compact(
            'advertisement',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TelegramBot $telegram_bot, AdvertisementRequest $request, Advertisement $advertisement)
    {
        $images = [];

        $advertisement->update(
            Arr::except($request->validated(), ['images'])
        );

        if ($request->has('delete_images')){
            foreach ($request->delete_images as $id) {
                $image = $advertisement->images()->find($id);
                $filePath = str_replace('/storage', 'public', $image->url);
                if (Storage::delete($filePath)){
                    $image->delete();
                }
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = ['url' => Storage::url($image->store('public/advertisements'))];
            }

            $advertisement->images()->createMany(
                $images
            );
        }

        return redirect()->route('admin.telegram_bot.advertisement.index')->with([
            'ok' => true,
            'description' => "Advertisement succesfuly updated"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TelegramBot $telegram_bot, Advertisement $advertisement)
    {
        $images = $advertisement->images;

        foreach ($images as $image) {
            $filePath = str_replace('/storage', 'public', $image->url);
            if (Storage::delete($filePath)){
                $image->delete();
            }
        }

        $advertisement->delete();

        return redirect()->route('advertisement.index')->with([
            'ok' => true,
            'description' => "Advertisement succesfuly deleted"
        ]);
    }
}
