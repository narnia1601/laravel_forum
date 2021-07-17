<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DiscussionController extends Controller
{
    public function index(){
        $discussions = Discussion::latest()->paginate(6);
        if(request('search')){
            $discussions = $this->getRelatedDiscussions(request('search'));
        }
        return view('dashboard', [
            'discussions' => $discussions
        ]);
    }

    public function show(Discussion $discussion){
        $filter = explode("-", $discussion->slug)[0];
        $relatedDiscussions = $this->getRelatedDiscussions($filter);
        $bestReply = $discussion->replies()->where('best_reply', 1)->first();
        $replies = $discussion->replies()->where('best_reply', 0)->get();
        if(count($relatedDiscussions) < 2){
            $relatedDiscussions = $this->getLatestDiscussions();
        }
        return view('discussions.show',[
            'discussion' => $discussion,
            'replies' => $replies,
            'bestReply' => $bestReply,
            'relatedDiscussions' => $relatedDiscussions,
        ]);
    }

    public function create(){
        return view('discussions.create');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|max:255',
            'channel' => 'required',
        ]);
        $slug = Str::slug(request('title'));
        Discussion::create([
            'user_id' => Auth::id(),
            'title' => request('title'),
            'content' => request('content'),
            'channel_id' => request('channel'),
            'slug' => $slug,
        ]);
        return redirect('/dashboard')->with('success', 'Discussion created');
    }

    public function destroy(Discussion $discussion){
        Discussion::destroy($discussion->id);
        return redirect('/dashboard')->with('success','Discussion destroyed');
    }

    public function getRelatedDiscussions($filter){
        $array = array("content" => 'content', 'title' => 'title');
        return Discussion::latest()->filter($filter,$array)->paginate(3)->withQueryString();
    }

    public function getLatestDiscussions(){
        return Discussion::latest()->paginate(3)->withQueryString();
    }
}
