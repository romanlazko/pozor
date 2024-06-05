<x-white-block>
    <div class="w-full space-y-6">
        <div class="space-y-2">
            <x-user-card :user="$user" />
        </div>
        
        @if ($contacts)
            <label class="text-gray-500 flex text-lg items-center space-x-3">
                <span>
                    {{ __("Phone:") }}
                </span>
                <a href="tel:{{ $user?->phone }}" class="inline-block w-full h-full text-blue-600 hover:underline cursor-pointer">{{ $user?->phone }}</a>
            </label>

            <label class="text-gray-500 flex text-lg items-center space-x-3">
                <span>
                    {{ __("Email:") }}
                </span>
                <a href="mailto:{{ $user?->email }}" class="inline-block w-full h-full text-blue-600 hover:underline cursor-pointer">{{ $user?->email }}</a>
            </label>
        @else
            <form wire:submit.prevent="submit">
                <x-honey recaptcha/>
                <x-buttons.secondary type="submit" class="w-full whitespace-nowrap text-center justify-center">
                    {{ __("Show contacts") }}
                </x-buttons.secondary>
                <small>This site is protected by reCAPTCHA and the Google 
                    <a href="https://policies.google.com/privacy" class="underline text-blue-500">Privacy Policy</a> and
                    <a href="https://policies.google.com/terms" class="underline text-blue-500">Terms of Service</a> apply.
                </small>
            </form>
            <x-form.error class="mt-2" :messages="$error" />
        @endif
    </div>
</x-white-block>

