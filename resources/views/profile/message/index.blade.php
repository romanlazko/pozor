<x-profile-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 gap-2 p-2">
        @forelse ($threads->sortByDesc('lastMessage.updated_at') ?? [] as $thread)
            <a href="{{ route('profile.message.show', $thread->id) }}"  class="flex items-center space-x-2 relative">
                @if ($thread?->uread_messages_count > 0)
                    <span class="block absolute text-xs text-white w-5 h-5 min-w-5 min-h-5 rounded-full bg-blue-500 text-center content-center items-center top-1 left-0 m-0">{{ $thread?->uread_messages_count }}</span>
                @endif
                <div class="w-12 h-12 min-w-12 min-h-12 rounded-full overflow-hidden bg-white-300 border ">
                    <img src="{{ $thread?->announcement?->getFirstMediaUrl('announcements', 'thumb') }}" alt="" class="object-cover h-full w-full">
                </div>
                <div>
                    <p class="font-bold">{{ ucfirst($thread?->announcement?->getFeatureByName('title')?->value) }}</p>
                    
                    @if ($thread?->recipient)
                        <div class="flex items-center space-x-1">
                            <div class="w-5 h-5 min-w-5 min-h-5 rounded-full overflow-hidden bg-white border">
                                <img src="{{ $thread?->recipient?->getFirstMediaUrl('avatar', 'thumb') }}" alt="" class="object-cover h-full w-full">
                            </div>
                            <p class="text-xs">{{ $thread?->recipient?->name }}</p>
                        </div>
                    @endif
                        
                    <p class="text-sm text-gray-500">
                        @if ($thread?->lastMessage?->user?->id == auth()->user()?->id)
                            {{ __('You: ') }}
                        @endif
                        {{ $thread?->lastMessage?->message }}
                    </p>
                </div>
            </a>
            @if (!$loop->last)
                <hr>
            @endif
        @empty
            <p>{{ __('No messages found.') }}</p>
        @endforelse
    </div>
</x-profile-layout>