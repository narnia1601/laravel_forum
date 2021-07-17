<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Discussion;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewReplyAdded;
use App\Notifications\ReplyMarkedAsBest;

class ReplyController extends Controller
{
    public function store(Request $request, Discussion $discussion){
        $request->validate([
            'reply' => 'required|max:255',
        ]);
        Reply::create([
            'user_id' => Auth::id(),
            'discussion_id' => $discussion->id,
            'body' => request('reply'),
        ]);
        $discussion->user->notify(new NewReplyAdded($discussion));
        return back()->with('primary', 'You have posted a comment');
    }

    public function bestReply(Discussion $discussion, Reply $reply){
        $discussion->replies()->update(['best_reply' => 0]);
        $reply->best_reply = true;
        $reply->save();
        $reply->user->notify(new ReplyMarkedAsBest($reply, $discussion));
        return back()->with('primary','You have selected a best reply for your discussion');
    }
}
