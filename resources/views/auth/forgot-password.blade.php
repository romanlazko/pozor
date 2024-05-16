<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form class="bg-white p-4 sm:p-6 max-w-md m-auto my-2 rounded-lg space-y-4 shadow-xl h-full" method="POST" action="{{ route('password.email') }}">
        <div class="text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>
        @csrf
        <x-honey/>
        <x-honey-recaptcha/> 

        <!-- Email Address -->
        <div>
            <x-form.label for="email" :value="__('Email')" />
            <x-form.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-form.error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="text-center space-y-4">
            <x-buttons.primary class="w-full text-center justify-center">
                {{ __('Email Password Reset Link') }}
            </x-buttons.primary>
        </div>

        <hr>
        <div>
            <small>This site is protected by reCAPTCHA and the Google 
                <a href="https://policies.google.com/privacy" class="underline text-blue-500">Privacy Policy</a> and
                <a href="https://policies.google.com/terms" class="underline text-blue-500">Terms of Service</a> apply.
            </small>
        </div>
    </form>
</x-guest-layout>
