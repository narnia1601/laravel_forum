<x-app-layout>
    <x-slot name="header">
        <form method="GET" class="bg-white relative">
            <input class="w-full rounded px-4 py-3" type="text" placeholder="Search for a discussion" name="search">
            <button class="bg-red-400 hover:bg-red-300 rounded text-white pl-4 pr-4 px-3 py-1 absolute bottom-2 right-6">
                <p class="font-semibold">Search</p>
            </button>
        </form>
    </x-slot>

    <div>
        <div class="grid grid-cols-3">
            <div class="col-span-2 ml-10">
                @if (Route::is('dashboard'))
                    <h1 class="-mt-6 text-xl">Categories:</h1>
                    <div class="flex">
                        @foreach ($channels as $channel)
                            @if (count($channel->discussions))
                                <a href="/channels/{{ $channel->slug }}" class="flex-initial px-4 py-2 text-blue-700">#{{ $channel->name }}</a>
                            @endif
                        @endforeach
                    </div>
                @else
                    <h1 class="-mt-6 text-xl">Category: </h1>
                    <div class="flex">
                        <a href="" class="flex-initial px-4 py-2 text-blue-700">#{{ $channel->name }}</a>
                    </div>
                @endif
            </div>
            <div class="col-span-1 flex justify-end">
                <a href="{{ route('discussions.create') }}"><button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full mr-10">Add Discussion</button></a>
            </div>
        </div>
        <div class="p-10 grid grid-cols-3 gap-5">
            @if (count($discussions))
                @foreach ($discussions as $discussion)
                    <div class="rounded overflow-hidden shadow-lg bg-gray-200 relative h-64">
                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">{{ $discussion->title }}</div>
                            <p class="text-gray-700 text-base max-h-20 line-clamp-3">
                            {{ $discussion->content }}
                            </p>
                        </div>
                        <a href="/channels/{{ $discussion->channel->slug }}" class="absolute left-2 bottom-2 py-2 px-2 text-blue-700 rounded">#{{ $discussion->channel->name }}</a>
                        <a href="/discussions/{{ $discussion->slug }}" class="absolute right-2 bottom-2 py-2 px-4 bg-green-500 text-white rounded-full">Find out more</a>
                    </div>
                @endforeach
            @else
                <h1 class="text-center col-span-3 mt-20">There are no results. Please enter another search request.</h1>
            @endif
        </div>
    </div>
    {{ $discussions->links() }}
</x-app-layout>
