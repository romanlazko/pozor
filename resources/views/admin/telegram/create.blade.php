<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create bot:') }}
        </h2>
    </x-slot>
    <div class="w-full space-y-6 m-auto max-w-2xl">
        <form method="post" action="{{ route('admin.company.telegram_bot.store', $company) }}" class="space-y-6">
            @csrf
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
                        <x-form.input id="token" name="token" type="password" class="mt-1 block w-full" :value="old('token')" required autocomplete="token" />
                        <x-form.error class="mt-2" :messages="$errors->get('token')" />
                    </div>
                </div>
            </x-white-block>

            <div class="flex justify-end">
                <x-buttons.primary>{{ __('Save') }}</x-buttons.primary>
            </div>
        </form>
    </div>
</x-app-layout>