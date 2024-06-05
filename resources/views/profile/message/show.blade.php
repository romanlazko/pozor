<x-body-layout>
    <x-slot name="headerNavigation">
        @include('layouts.header')
    </x-slot>

    <x-slot name="sidebar">
        <x-profile-nav/>
    </x-slot>

    <x-slot name="header">
        <a href="{{ route('profile.message.index') }}"  class="my-0.5 inline-block p-1.5 bg-gray-800 rounded-lg text-white text-xs xl:text-sm hover:bg-gray-600 h-min">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div class="flex w-full">
            <div class="flex items-center space-x-2">
                <div class="w-12 h-12 min-w-12 min-h-12 rounded-full overflow-hidden bg-white border aspect-square">
                    <img src="{{ $thread->announcement->getFirstMediaUrl('announcements', 'thumb') }}" alt="" class="object-cover">
                </div>
                <p class="font-bold">{{ $thread->announcement->title }}</p>
            </div>
        </div>
    </x-slot>
    
    <div class="grid grid-cols-1 gap-2 p-2" x-init="window.scrollTo(0,document.body.scrollHeight)">
        @foreach ($messages as $message)
            <div class="w-full">
                <div @class(['flex space-x-2', 'float-right right-0' => auth()->user()->id == $message->user_id])>
                    
                    <div @class(['p-2 shadow-sm rounded-lg space-y-2', 'bg-blue-100' => auth()->user()->id == $message->user_id, 'bg-white' => auth()->user()->id != $message->user_id])>
                        <div class="h-6 flex items-center space-x-2">
                            <img src="{{ $message->user->getFirstMediaUrl('avatar', 'thumb') }}" alt="" class="min-w-6 min-h-6 w-6 h-6 rounded-full">
                            <p class="text-xs text-gray-500">{{ $message->user->name }}</p>
                        </div>
                        
                        <p class="max-w-lg whitespace-pre-wrap">{{ $message->message }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $message->created_at->diffForHumans() }} 
                            @if (auth()->user()->id == $message->user_id AND $message->read_at)
                                ✓
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <x-slot name="footer">
        <form action="{{ route('profile.message.update', $thread->id) }}" method="post" class="w-full p-2">
            @csrf
            @method('put')
            <div class="flex items-end space-x-2">
                @livewire('components.textarea')
                <x-buttons.primary type="submit">
                    {{ __('Send') }}
                </x-buttons.primary>
            </div>
        </form>
    </x-slot>
</x-body-layout>



