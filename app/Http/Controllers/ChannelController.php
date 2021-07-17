<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Channel;

class ChannelController extends Controller
{
    public function show(Channel $channel){
        $discussions = $channel->discussions()->paginate(3);
        return view('dashboard', [
            'discussions' => $discussions,
            'channel' => $channel
        ]);
    }
}
