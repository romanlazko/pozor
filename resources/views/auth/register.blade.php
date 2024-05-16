<x-guest-layout>
    <form class="bg-white p-4 sm:p-6 max-w-md m-auto my-2 rounded-lg space-y-4 shadow-xl h-full" method="POST"  action="{{ route('register') }}">
        @csrf
        <x-honey/>
        <x-honey-recaptcha/> 
        <!-- Name -->
        <div>
            <x-form.label for="name" :value="__('Name')" />
            <x-form.input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-form.error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-form.label for="email" :value="__('Email')" />
            <x-form.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-form.error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-form.label for="password" :value="__('Password')" />

            <x-form.input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-form.error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-form.label for="password_confirmation" :value="__('Confirm Password')" />

            <x-form.input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-form.error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="space-y-4 text-center">
            

            <x-buttons.primary class="w-full text-center justify-center">
                {{ __('Register') }}
            </x-buttons.primary>
            <a class="block underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
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
