<x-user-layout>
    <div class="w-full overflow-y-auto">
        <form class="bg-white p-4 sm:p-6 max-w-md m-auto my-2 md:my-12 rounded-none sm:rounded-lg" method="POST" action="{{ route('register') }}">
            @csrf
    
            <!-- Name -->
            <div>
                <x-form.label for="name" :value="__('Name')" />
                <x-form.input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-form.error :messages="$errors->get('name')" class="mt-2" />
            </div>
    
            <!-- Email Address -->
            <div class="mt-4">
                <x-form.label for="email" :value="__('Email')" />
                <x-form.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-form.error :messages="$errors->get('email')" class="mt-2" />
            </div>
    
            <!-- Password -->
            <div class="mt-4">
                <x-form.label for="password" :value="__('Password')" />
    
                <x-form.input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
    
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
    
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
    
                <x-buttons.primary class="ms-4">
                    {{ __('Register') }}
                </x-buttons.primary>
            </div>
        </form>
    </div>
</x-user-layout>
