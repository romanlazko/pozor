<?php

namespace App\Http\Controllers;

use App\Jobs\SendMessageJob;
use App\Models\Announcement;
use App\Models\Messanger\Thread;
use App\Models\User;
use App\Notifications\MessageSent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MessagesController extends Controller
{
    /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */
    public function index()
    {
        $threads = auth()->user()->threads->load('announcement', 'messages', 'announcement.media');

        return view('messenger.index', compact('threads'));
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

        return view('messenger.show', compact('thread', 'messages'));
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

        // $recipient = $thread->users()->where('user_id', '!=', auth()->id())->first();

        // $thread->messages->last()->user->notify(new MessageSent($thread));

        return redirect()->back();
    }
}
