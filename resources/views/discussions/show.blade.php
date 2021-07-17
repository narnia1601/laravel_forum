<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div>
        <div class="grid grid-cols-3">
            <div class="col-span-2 ml-10">
                <h1 class="-mt-6 text-xl">Category:</h1>
                <div class="flex">
                    <a href="/channels/{{ $discussion->channel->slug }}" class="flex-initial px-4 py-2 text-blue-700">#{{ $discussion->channel->name }}</a>
                </div>
            </div>
            <div class="col-span-1 flex justify-end">
                <a href="{{ route('discussions.create') }}"><button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full mr-3">Add Discussion</button></a>
                @if ($discussion->user->id == Auth::id())
                    <form action="/discussions/{{ $discussion->slug }}/delete" method="POST">
                        @csrf
                        <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-full mr-10">Delete Discussion</button>
                    </form>
                @endif
            </div>
        </div>
        <div class="p-10 grid grid-cols-8 gap-5">
            <div class="col-span-6">
                <div class="rounded overflow-hidden shadow-lg bg-gray-200 relative">
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2">{{ $discussion->title }}</div>
                        <p class="text-gray-700 text-base pt-5">
                        {{ $discussion->content }}
                        </p>
                    </div>
                </div>
                @auth
                    <div class="rounded overflow-hidden shadow-lg bg-gray-200 mt-6 p-4">
                        <form method="POST" action="/discussions/{{ $discussion->slug }}/store">
                            @csrf
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <h2 class="px-4 pt-3 pb-2 text-gray-800 text-lg">Add a new comment</h2>
                                <div class="w-full md:w-full px-3 mb-2 mt-2">
                                    <textarea class="bg-gray-100 rounded border border-gray-400 leading-normal resize-none w-full h-20 py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white @error('reply') border-red-500 @enderror" name="reply" placeholder='Type Your Comment'></textarea>
                                    @error('reply')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="w-full md:w-full flex items-start md:w-full px-3">
                                    <div class="flex items-start w-1/2 text-gray-700 px-2 mr-auto"></div>
                                    <div class="-mr-1">
                                    <input type='submit' class="bg-white text-gray-700 font-medium py-1 px-4 border border-gray-400 rounded-lg tracking-wide mr-1 hover:bg-gray-100" value='Post Comment'>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endauth
                @if (isset($bestReply))
                    <div class="rounded overflow-hidden shadow-lg bg-gray-200 mt-6 p-4 relative h-28">
                        <h1><span class="text-lg">{{ $bestReply->user->name }}</span> commented {{ $bestReply->created_at->diffForHumans() }}</h1>
                        <div class="grid grid-cols-5">
                            <p class="col-span-4">{{ $bestReply->body }}</p>
                            <span class="ml-20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                    </div>
                @endif
                @foreach ($replies as $reply)
                    <div class="rounded overflow-hidden shadow-lg bg-gray-200 mt-6 p-4 relative h-28">
                        <h1><span class="text-lg">{{ $reply->user->name }}</span> commented {{ $reply->created_at->diffForHumans() }}</h1>
                        <div class="grid grid-cols-5">
                            <p class="col-span-4">{{ $reply->body }}</p>
                            @if ($discussion->user->id == Auth::id())
                                <form action="/discussions/{{ $reply->discussion->id }}/{{ $reply->id }}/bestReply" method="POST">
                                    @csrf
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded absolute bottom-0 right-10 bottom-9">Best Reply</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
                @if (!Auth::user())
                    <p class="text-center mt-3"><a href="/login" class="text-blue-500">Login</a> or <a href="/register" class="text-blue-500">Register</a> to reply to this discussion.</p>
                @endif
            </div>
            <div class="col-span-2">
                <h1 class="text-xl text-center mb-3">Related discussions</h1>
                @foreach ($relatedDiscussions as $relatedDiscussion)
                    @if ($relatedDiscussion->id != $discussion->id)
                        <div class="rounded overflow-hidden shadow-lg bg-gray-200 mb-4">
                            <div class="px-6 py-4">
                                <div class="font-bold text-xl mb-2 text-blue-400"><a href="/discussions/{{ $relatedDiscussion->slug }}">{{ $relatedDiscussion->title }}</a></div>
                                <p class="text-gray-700 text-base pt-10">
                                {{ $relatedDiscussion->content }}
                                </p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
