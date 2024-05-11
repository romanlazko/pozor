@props(['announcement'])

<x-white-block>
    <div class="w-full space-y-4">
        <div class="flex space-x-4 items-center">
            <img src="{{ $announcement->user->getFirstMediaUrl('avatar', 'thumb') }}" alt="" class="rounded-full w-14 h-14 lg:w-16 lg:h-16 aspect-square">
            <div class="w-full">
                <span class="block font-bold">{{ $announcement->user->name }}</span>
                <a class="block text-gray-700 hover:underline cursor-pointer">{{ $announcement->user->email }}</a>
                <span class="block text-gray-500 text-xs">{{ $announcement->user->created_at->diffForHumans() }}</span>
            </div>
        </div>

        {{-- <livewire:components.send-message :announcement_id="$announcement->id"/> --}}

        <form action="{{ route('profile.message.store') }}" method="POST">
            @csrf
            <input type="hidden" name="announcement_id" value="{{ $announcement->id }}">
            <x-form.textarea name="message" placeholder="Write a message" required rows="6"/>
            <x-buttons.primary>Send</x-buttons.primary>
        </form>
    </div>
</x-white-block>