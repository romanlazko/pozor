<x-profile-layout>

    <x-slot name="header">
        <div class="flex items-center space-x-2 py-2">
            <div class="w-12 h-12 rounded-full overflow-hidden bg-white">
                <img src="{{ $thread->announcement->getFirstMediaUrl('announcements') }}" alt="" class="object-cover h-12  ">
            </div>
            
            <p class="font-bold">{{ $thread->announcement->translated_title }}</p>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 gap-2">
        @foreach ($messages as $message)
            <div class="w-full">
                
                <div @class(['flex space-x-2', 'float-right right-0' => auth()->user()->id == $message->user_id])>
                    
                    <div @class(['p-2 shadow-sm rounded-lg space-y-2', 'bg-blue-100' => auth()->user()->id == $message->user_id, 'bg-white' => auth()->user()->id != $message->user_id])>
                        <div class="h-6 flex items-center space-x-2">
                            <img src="{{ $message->user->getFirstMediaUrl('avatar', 'thumb') }}" alt="" class="w-6 rounded-full">
                            <p class="text-xs text-gray-500">{{ $message->user->name }}</p>
                        </div>
                        
                        <p class="max-w-lg">
                            {{ $message->message }}
                        </p>
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
                <textarea name="message" placeholder="Write your message here..." class="w-full hover:border-indigo-600 border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm p-2"></textarea>
                <x-buttons.primary type="submit">Send</x-buttons.primary>
            </div>
            
        </form>
    </x-slot>
</x-profile-layout>
