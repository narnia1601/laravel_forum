<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Discussion
        </h2>
    </x-slot>

    <x-slot name="table">
        <ul class="px-0">
            @foreach ($channels as $channel)
                <li class="border list-none rounded-sm px-3 py-3">{{ $channel->name }}</li>
            @endforeach
        </ul>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="w-full">
                        <form method="POST" action="{{ route('discussions.store') }}">
                            @csrf
                            <div class="mb-4">
                            <label class="text-gray-700 text-sm font-bold mb-2" for="title">Title</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight @error('title') border-red-500 @enderror" name="title" id="title" type="text" placeholder="Enter discussion title" value="{{ old('title') }}">
                            @error('title')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                            </div>
                            <div class="mb-4">
                            <label class="text-gray-700 text-sm font-bold mb-2" for="content">Content</label>
                            <textarea name="content" class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight @error('content') border-red-500 @enderror" id="content" cols="20" rows="5" placeholder="Enter discussion content">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                            </div>
                            <div class="mb-4">
                                <select name="channel" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded leading-tight @error('channel') border-red-500 @enderror">
                                    <option value="">Select channel</option>
                                    @foreach ($channels as $channel)
                                        <option value="{{ $channel->id }}" @if (old('channel') == $channel->id) selected @endif>{{ $channel->name }}</option>
                                    @endforeach
                                </select>
                                @error('channel')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded rounded-lg" type="submit">
                                Create Discussion
                            </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
