<x-admin-layout>
    <x-slot name="navigation">
        <x-form.search :action="route('admin.company.telegram_bot.chat.index', [$company, $telegram_bot] )" :placeholder="__('Search by chats')"/>
        <x-header.menu>
            <x-header.link href="{{ route('admin.company.telegram_bot.chat.show', [$company, $telegram_bot, $chat]) }}" :active="request()->routeIs('admin.company.telegram_bot.chat.show')">
                {{ __('Chat') }}
            </x-header.link>
            <x-header.link href="{{ route('admin.company.telegram_bot.chat.edit', [$company, $telegram_bot, $chat]) }}" :active="request()->routeIs('admin.company.telegram_bot.chat.edit')">
                {{ __('Settings') }}
            </x-header.link>
        </x-header.menu>
    </x-slot>
    
    <x-slot name="header">
        <div class="flex items-center justify-between w-min space-x-2">
            <x-a-buttons.back href="{{ route('admin.company.telegram_bot.chat.index', [$company, $telegram_bot] ) }}"/>
            <div class="flex items-center">
                <div class="flex-col items-center my-auto">
                    <img src="{{ $chat->photo ?? null }}" alt="Avatar" class="mr-4 w-12 h-12 min-w-[48px] rounded-full">
                </div>
                <div class="flex-col justify-center">
                    <div>
                        <a href="{{ route('admin.company.telegram_bot.chat.show', [$company, $telegram_bot, $chat]) }}" class="w-full text-sm font-light text-gray-500 mb-1 hover:underline">
                            {{ $chat->chat_id ?? null }}
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('admin.company.telegram_bot.chat.show', [$company, $telegram_bot, $chat]) }}" class="w-full text-md font-medium text-gray-900 whitespace-nowrap">
                            {{ $chat->first_name ?? null }} {{ $chat->last_name ?? null }}
                        </a>
                    </div>
                    <div>
                        <a class="w-full text-sm font-light text-blue-500 hover:underline" href="{{ $chat->contact }}" target="_blank">
                            {{ "@".($chat->username ?? $chat->first_name.$chat->last_name) }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    
    <div class="space-y-6">
        <div class=" bg-gray-200 space-y-6">
            @foreach ($messages->reverse() as $message)
                @if ($message->user?->is_bot === 0 OR $message->callback_query?->user?->is_bot === 0 OR $message->sender_chat)
                    <x-message.block class="mr-6 ml-1">
                        @if ($message->photo)
                            <x-message.img class="rounded-md" :src=" $message->photo "/>
                        @endif
                        <x-message.text :message="$message" class="bg-white"/>
                        <x-message.buttons :message="$message"/>
                    </x-message.block>
                @else
                    <x-message.block class="sm:ml-auto ml-6 mr-1">
                        @if ($message->photo)
                            <x-message.img class="rounded-md" :src=" $message->photo "/>
                        @endif

                        <x-message.text :message="$message" class="bg-blue-50"/>
                        <x-message.buttons :message="$message"/>
                    </x-message.block>
                @endif
            @endforeach
        </div>
    </div>

    <x-slot name='footer'>
        <div class="w-full p-2 space-y-2">
            <div class="">
                {{$messages->links()}}
            </div>
            {{-- <x-message.send :action="route('message.store', $chat)"/> --}}
        </div>
    </x-slot>
</x-app-layout>