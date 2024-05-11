<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Messanger\Thread;
use App\Notifications\NewMessage;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */
    public function index()
    {
        $threads = auth()->user()->threads?->load('announcement', 'messages', 'announcement.media')
            ->loadCount(['messages as uread_messages_count' => function ($query) {
                $query->where('read_at', null)->where('user_id', '!=', auth()->id());
            }]);

        return view('profile.messenger.index', compact('threads'));
    }

    /**
     * Shows a message thread.
     *
     * @param $id
     * @return mixed
     */
    public function show(Thread $thread)
    {
        $messages = $thread->messages->load('user');

        $messages->where('user_id', '!=', auth()->id())->each( function ($message) {
            $message->update(['read_at' => now()]);
        });

        return view('profile.messenger.show', compact('thread', 'messages'));
    }

    /**
     * Stores a new message thread.
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $announcement = Announcement::findOrFail($request->announcement_id);

        if ($announcement->user->id == auth()->id()) {
            return redirect()->back();
        }

        $thread = auth()->user()->threads()->where('announcement_id', $announcement->id)->first();

        if (!$thread) {
            $thread = auth()->user()->threads()->create([
                'announcement_id' => $announcement->id,
            ]);

            $thread->users()->attach([$announcement->user->id]);
        }

        return $this->update($thread, $request);
    }

    /**
     * Adds a new message to a current thread.
     *
     * @param $id
     * @return mixed
     */
    public function update(Thread $thread, Request $request)
    {
        $thread->messages()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return redirect()->back();
    }
}
