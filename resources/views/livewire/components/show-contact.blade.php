<x-white-block>
    @if ($phone)
        <a href="tel:{{ $phone }}" class="inline-block w-full h-full">{{ $phone }}</a>
    @else
        <form wire:submit.prevent="submit">
            <x-honey recaptcha/>
            <x-buttons.secondary type="submit" class="w-full whitespace-nowrap text-center justify-center">
                {{ __("Show phone") }}
            </x-buttons.secondary>
        </form>
        <x-form.error class="mt-2" :messages="$error" />
    @endif
    <small>This site is protected by reCAPTCHA and the Google 
        <a href="https://policies.google.com/privacy" class="underline text-blue-500">Privacy Policy</a> and
        <a href="https://policies.google.com/terms" class="underline text-blue-500">Terms of Service</a> apply.
    </small>
</x-white-block>

