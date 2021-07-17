<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DiscussionController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/discussions/{discussion:slug}', [DiscussionController::class,'show'])->name('discussions.show');
Route::get('/channels/{channel:slug}', [ChannelController::class,'show'])->name('channels.show');

Route::middleware(['auth'])->group(function(){
    Route::get('/create', [DiscussionController::class,'create'])->name('discussions.create');
    Route::post('/store', [DiscussionController::class,'store'])->name('discussions.store');
    Route::post('/discussions/{discussion:slug}/store', [ReplyController::class,'store'])->name('replies.store');
    Route::post('/discussions/{discussion:slug}/delete', [DiscussionController::class,'destroy']);
    Route::post('/discussions/{discussion:id}/{reply:id}/bestReply', [ReplyController::class,'bestReply']);
    Route::get('/user/notifications', [UserController::class,'show'])->name('notifications');
});

Route::get('/email/verify', function(){
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (sendEmailVerificationRequest $request){
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

require __DIR__.'/auth.php';