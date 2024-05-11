<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Telegram') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your telegram information.") }}
        </p>
    </header>

    @if (!Auth::user()->telegram_chat)
        <a href="https://t.me/posorbottestbot?start=connect.{{ auth()->user()->id }}" class="mt-6 text-sm text-blue-500 hover:text-blue-700 hover:underline">{{ __('Connect Telegram') }}</a>
    @else
        
    @endif
</section>