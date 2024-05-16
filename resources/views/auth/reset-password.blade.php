<x-guest-layout>
    <form class="bg-white p-4 sm:p-6 max-w-md m-auto my-2 rounded-lg space-y-4 shadow-xl h-full" method="POST" action="{{ route('password.store') }}">
        @csrf
        <x-honey/>
        <x-honey-recaptcha/> 
        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-form.label for="email" :value="__('Email')" />
            <x-form.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-form.error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-form.label for="password" :value="__('Password')" />
            <x-form.input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-form.error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-form.label for="password_confirmation" :value="__('Confirm Password')" />

            <x-form.input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-form.error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="text-center space-y-4">
            <x-buttons.primary class="w-full text-center justify-center">
                {{ __('Reset Password') }}
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
