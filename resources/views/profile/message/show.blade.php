

    {{-- <div class="flex flex-col flex-1 overflow-hidden h-20" data=""> --}}
        {{-- <div class="w-full items-center justify-between flex space-x-3 sticky top-0 z-30 p-2 md:p-0 border-b lg:border-none">
            <a href="{{ route('profile.message.index') }}" class="my-0.5 inline-block p-1.5 bg-gray-800 rounded-lg text-white text-xs xl:text-sm hover:bg-gray-600 h-min">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
    
            <div class="flex w-full">
                <div class="flex items-center space-x-2">
                    <div class="w-12 h-12 min-w-12 min-h-12 rounded-full overflow-hidden bg-white border aspect-square">
                        <img src="{{ $thread->announcement->getFirstMediaUrl('announcements', 'thumb') }}" alt="" class="object-cover h-full w-full">
                    </div>
    
                    <div>
                        <p class="font-bold">{{ $thread->announcement->title }}</p>
    
                        <div class="flex items-center space-x-1">
                            <div class="w-5 h-5 min-w-5 min-h-5 rounded-full overflow-hidden bg-white border">
                                <img src="{{ $thread?->recipient?->getFirstMediaUrl('avatar', 'thumb') }}" alt="" class="object-cover h-full w-full">
                            </div>
                            <p class="text-xs">{{ $thread?->recipient?->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    
        <div id="messages" class=" grid grid-cols-1 gap-2 p-2">
            @foreach ($messages as $message)
                <div class="w-full">
                    <div @class(['flex space-x-2', 'float-right right-0' => auth()->user()->id == $message->user_id])>
                        <div @class(['p-2 shadow-sm rounded-lg space-y-1', 'bg-blue-100 ml-2' => auth()->user()->id == $message->user_id, 'bg-gray-100 mr-2' => auth()->user()->id != $message->user_id])>
                            
                            <p class="text-sm break-all">{{ $message->message }}</p>

                            <p class="text-[9px] text-gray-500">
                                {{ $message->created_at->format('H:i') }} 
                                @if (auth()->user()->id == $message->user_id AND $message->read_at)
                                    ✓
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    {{-- </div> --}}
    



