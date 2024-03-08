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
            <x-a-buttons.back href="{{ route('admin.company.telegram_bot.chat.show', [$company, $telegram_bot, $chat]) }}"/>
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
    
    <div class="w-full space-y-6 m-auto max-w-2xl">
        <form method="post" action="{{ route('admin.company.telegram_bot.chat.update', [$company, $telegram_bot, $chat]) }}" class="space-y-6">
            @csrf
            @method('PUT')
            <x-white-block>
                <div class="space-y-4">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Chat settings') }}
                    </h2>
                    <hr>
                    <div>
                        <x-form.label for="role" :value="__('Role:')" />
                        <x-form.select id="role" name="role" class="mt-1 block w-full" required>
                            <option @selected($chat->role == 'admin') value="admin">Admin</option>
                            <option @selected($chat->role == 'user') value="user">User</option>
                            <option @selected($chat->role == 'blocked') value="blocked">Blocked</option>
                        </x-form.select>
                        <x-form.error class="mt-2" :messages="$errors->get('role')" />
                    </div>
                </div>
            </x-white-block>

            <div class="flex justify-end">
                <x-buttons.primary>{{ __('Save') }}</x-buttons.primary>
            </div>
        </form>
    </div>
</x-app-layout>