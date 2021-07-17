<x-app-layout>
    <x-slot name="header">
        Notifications Page
    </x-slot>
    @foreach ($notifications as $notification)
        <div class="rounded overflow-hidden shadow-lg bg-gray-200 mt-6 p-4 relative">
            @if ($notification->type == 'App\Notifications\NewReplyAdded')
                <h1>A new reply has been added to your <a class="text-blue-500" href="{{ route('discussions.show', $notification->data['discussion']['slug']) }}">discussion</a></h1>
            @elseif ($notification->type == 'App\Notifications\ReplyMarkedAsBest')
                <h1>Your reply <span class="text-blue-500">{{ $notification->data['reply']['body'] }}</span> has been selected as best reply in the <a href="{{ route('discussions.show', $notification->data['discussion']['slug']) }}" class="text-blue-500">discussion</a></h1>
            @endif
        </div>
    @endforeach
</x-app-layout>
