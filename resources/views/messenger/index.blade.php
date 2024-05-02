<x-profile-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Messenges') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 gap-2">
        @forelse ($threads as $thread)
            <a href="{{ route('message.show', $thread->id) }}" class="flex items-center space-x-2">
                <div class="w-12 h-12 rounded-full overflow-hidden bg-red-300">
                    <img src="{{ $thread->announcement->getFirstMediaUrl('announcements') }}" alt="" class="object-cover h-12  ">
                </div>
                <div>
                    <p class="font-bold">{{ $thread->announcement->translated_title }}</p>
                    <p class="text-sm text-gray-500">{{ $thread?->messages?->last()?->message }}</p>
                </div>
            </a>
            <hr>
        @empty
            <p>{{ __('No messages found.') }}</p>
        @endforelse
    </div>
</x-profile-layout>