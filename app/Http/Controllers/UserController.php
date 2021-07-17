<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(){
        auth()->user()->unreadNotifications->markAsRead();
        return view('users.notifications', [
            'notifications' => auth()->user()->notifications
        ]);
    }
}
