<x-admin-layout>
    <x-slot name="navigation">
        <x-form.search :action="route('admin.company.telegram_bot.chat.index', [$company, $telegram_bot] )" :placeholder="__('Search by chats')"/>
        <x-header.menu>
            <x-header.link href="{{ route('admin.company.telegram_bot.show', [$company, $telegram_bot]) }}" class="float-right" :active="request()->routeIs('admin.company.telegram_bot.show')">
                {{ __('Bot') }}
            </x-header.link>
            <x-header.link href="{{ route('admin.company.telegram_bot.chat.index', [$company, $telegram_bot] ) }}" class="float-right" :active="request()->routeIs('admin.company.telegram_bot.chat.*')">
                {{ __('Chats') }}
            </x-header.link>
            <x-header.link href="{{ route('admin.company.telegram_bot.edit', [$company, $telegram_bot]) }}" class="float-right" :active="request()->routeIs('admin.company.telegram_bot.edit')">
                {{ __('Settings') }}
            </x-header.link>
        </x-header.menu>
    </x-slot>

    <x-slot name="header">
        <div class="sm:flex items-center sm:space-x-3 w-max">
            <div class="flex items-center">
                <div class="flex-col items-center my-auto">
                    <img src="{{ $telegram_bot->photo ?? null }}" alt="Avatar" class="mr-4 w-12 h-12 min-w-[48px] rounded-full">
                </div>
                <div class="flex-col justify-center">
                    <div>
                        <a href="{{ route('admin.company.telegram_bot.show', [$company, $telegram_bot]) }}" class="w-full text-sm font-light text-gray-500 mb-1 hover:underline">
                            {{ $telegram_bot->id ?? null }}
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('admin.company.telegram_bot.show', [$company, $telegram_bot]) }}" class="w-full text-md font-medium text-gray-900">
                            {{ $telegram_bot->first_name ?? null }} {{ $telegram_bot->last_name ?? null }}
                        </a>
                    </div>
                    <div>
                        <a class="w-full text-sm font-light text-blue-500 hover:underline" href="https://t.me/{{$telegram_bot->username}}">
                            {{ "@".($telegram_bot->username ?? null) }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    
    <div class="w-full space-y-6 m-auto max-w-2xl">
        <form method="post" action="{{ route('admin.company.telegram_bot.update', [$company, $telegram_bot]) }}" class="space-y-6">
            @csrf
            @method('PUT')
            <x-white-block>
                <div class="space-y-4">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('WebHook setup') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Use this form to specify a URL and receive incoming updates via an outgoing webhook.') }}
                    </p>
                    <hr>
                    <div>
                        <x-form.label for="token" :value="__('Token:')" />
                        <x-form.input id="token" name="token" type="password" class="mt-1 block w-full" :value="old('token', $telegram_bot->token)" required autocomplete="token" />
                        <x-form.error class="mt-2" :messages="$errors->get('token')" />
                    </div>
                </div>
            </x-white-block>
            
            <x-white-block>
                <div class="space-y-4">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Hello message') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Use this form to specify a first message after start bot.') }}
                    </p>
                    <hr>
                    <div class="flex space-x-2 items-center">
                        <x-form.label for="ru_message" :value="__('RU:')" />
                        <x-form.textarea id="ru_message" name="settings[message][ru]" type="text" class="mt-1 block w-full" :value="old('ru_message', $telegram_bot->settings->message->ru ?? null)" required autocomplete="ru_message" />
                        <x-form.error class="mt-2" :messages="$errors->get('ru_message')" />
                    </div>
                    <div class="flex space-x-2 items-center">
                        <x-form.label for="en_message" :value="__('EN:')" />
                        <x-form.textarea id="en_message" name="settings[message][en]" type="text" class="mt-1 block w-full" :value="old('en_message', $telegram_bot->settings->message->en ?? null)" required autocomplete="en_message" />
                        <x-form.error class="mt-2" :messages="$errors->get('en_message')" />
                    </div>
                    <div class="flex space-x-2 items-center">
                        <x-form.label for="cz_message" :value="__('CZ:')" />
                        <x-form.textarea id="cz_message" name="settings[message][cz]" type="text" class="mt-1 block w-full" :value="old('cz_message', $telegram_bot->settings->message->cz ?? null)" required autocomplete="cz_message" />
                        <x-form.error class="mt-2" :messages="$errors->get('cz_message')" />
                    </div>
                </div>
            </x-white-block>

            <x-white-block>
                <div class="space-y-4">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Settings') }}
                    </h2>
                    <div class="border rounded-md p-3">
                        <div class="flex space-x-2 items-center py-3 border-b">
                            <x-form.label for="" class="w-full ">
                                <div class="flex justify-between w-full items-center">
                                    <span>
                                        {{ __("Can customer cancel an appointment via bot")  }}
                                    </span>
                                    <x-form.checkbox id="" name="settings[can_client_cancel_appointment]" type="checkbox" :checked="old('settings[can_client_cancel_appointment]', $telegram_bot->settings->can_client_cancel_appointment ?? null)"/>
                                </div>
                            </x-form.label>
                        </div>
                        <div class="flex space-x-2 items-center py-3 ">
                            <x-form.label for="" class="w-full ">
                                <div class="flex justify-between w-full items-center">
                                    <span>
                                        {{ __("Maximum number of active appointments at the customer")  }}
                                    </span>
                                    <x-form.input id="" name="settings[max_active_appointments]" type="number" :value="old('settings[max_active_appointments]', $telegram_bot->settings->max_active_appointments ?? 1)"/>
                                </div>
                            </x-form.label>
                        </div>
                    </div>
                </div>
            </x-white-block>
            <div class="flex justify-end">
                <x-buttons.primary>{{ __('Save') }}</x-buttons.primary>
            </div>
        </form>
    </div>
</x-app-layout>