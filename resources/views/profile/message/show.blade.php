<x-body-layout>
    {{-- <x-slot name="navigation">
        @include('layouts.navigation')
    </x-slot> --}}

    <x-slot name="headerNavigation">
        @include('layouts.header')
    </x-slot>

    <x-slot name="sidebar">
        <x-profile-nav/>
    </x-slot>

    <div class="flex flex-col flex-1 overflow-hidden h-20">
        <div class="w-full items-center justify-between flex space-x-3 sticky top-0 z-30 p-2 md:p-0 border-b lg:border-none">
            <a href="{{ route('profile.message.index') }}" class="my-0.5 inline-block p-1.5 bg-gray-800 rounded-lg text-white text-xs xl:text-sm hover:bg-gray-600 h-min">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
    
            <div class="flex w-full">
                <div class="flex items-center space-x-2">
                    <div class="w-12 h-12 min-w-12 min-h-12 rounded-full overflow-hidden bg-white border aspect-square">
                        <img src="{{ $thread->announcement->getFirstMediaUrl('announcements', 'thumb') }}" alt="" class="object-cover h-full w-full">
                    </div>
    
                    <div>
                        <p class="font-bold">{{ $thread->announcement->getFeatureByName('title')->value }}</p>
    
                        <div class="flex items-center space-x-1">
                            <div class="w-5 h-5 min-w-5 min-h-5 rounded-full overflow-hidden bg-white border">
                                <img src="{{ $thread?->recipient?->getFirstMediaUrl('avatar', 'thumb') }}" alt="" class="object-cover h-full w-full">
                            </div>
                            <p class="text-xs">{{ $thread?->recipient?->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div id="messages" class=" grid grid-cols-1 gap-2 p-2 flex-1 h-full overflow-auto" x-init="document.getElementById('messages').scrollTo(0,document.body.scrollHeight)">
            @foreach ($messages as $message)
                <div class="w-full">
                    <div @class(['flex space-x-2', 'float-right right-0' => auth()->user()->id == $message->user_id])>
                        <div @class(['p-2 shadow-sm rounded-lg space-y-2', 'bg-blue-100' => auth()->user()->id == $message->user_id, 'bg-gray-100' => auth()->user()->id != $message->user_id])>
                            <div class="h-6 flex items-center space-x-2">
                                <img src="{{ $message->user->getFirstMediaUrl('avatar', 'thumb') }}" alt="" class="min-w-6 min-h-6 w-6 h-6 rounded-full object-cover">
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
        <form action="{{ route('profile.message.update', $thread->id) }}" method="post" class="w-full p-2 bg-white rounded-lg border">
            @csrf
            @method('put')
            <div class="flex items-end space-x-2">
                @livewire('components.textarea')
                <x-buttons.primary type="submit">
                    <i class="fa-solid fa-paper-plane"></i>
                </x-buttons.primary>
            </div>
        </form>
    </div>
    

    {{-- <div class="w-full  bg-red-300 overflow-y-auto"> --}}
        {{-- <div class="flex-1 grid grid-cols-1 gap-2 p-2 overflow-auto" x-init="window.scrollTo(0,document.body.scrollHeight)">
            @foreach ($messages as $message)
                <div class="w-full">
                    <div @class(['flex space-x-2', 'float-right right-0' => auth()->user()->id == $message->user_id])>
                        <div @class(['p-2 shadow-sm rounded-lg space-y-2', 'bg-blue-100' => auth()->user()->id == $message->user_id, 'bg-gray-100' => auth()->user()->id != $message->user_id])>
                            <div class="h-6 flex items-center space-x-2">
                                <img src="{{ $message->user->getFirstMediaUrl('avatar', 'thumb') }}" alt="" class="min-w-6 min-h-6 w-6 h-6 rounded-full object-cover">
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
        </div> --}}
    {{-- </div> --}}
    
    
    {{-- <x-slot name="footer">
        <form action="{{ route('profile.message.update', $thread->id) }}" method="post" class="w-full p-2">
            @csrf
            @method('put')
            <div class="flex items-end space-x-2">
                @livewire('components.textarea')
                <x-buttons.primary type="submit">
                    <i class="fa-solid fa-paper-plane"></i>
                </x-buttons.primary>
            </div>
        </form>
    </x-slot> --}}
</x-body-layout>



