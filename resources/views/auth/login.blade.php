<x-user-layout>
    <!-- Session Status -->
    <div class="w-full overflow-y-auto">
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form class="bg-white p-4 sm:p-6 max-w-md m-auto my-2 md:my-12 rounded-none sm:rounded-lg" method="POST" action="{{ route('login') }}">
            @csrf
            <x-honey/>
            <x-honey-recaptcha/> 
            <!-- Email Address -->
            <div>
                <x-form.label for="email" :value="__('Email')" />
                <x-form.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-form.error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-form.label for="password" :value="__('Password')" />

                <x-form.input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-form.error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-buttons.primary class="ms-3">
                    {{ __('Log in') }}
                </x-buttons.primary>
            </div>
        </form>
    </div>
</x-user-layout>
