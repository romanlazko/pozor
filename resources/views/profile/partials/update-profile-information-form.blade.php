<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    {{-- <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form> --}}

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-form.label :value="__('Avatar')" />
            <label for="avatar" class="block text-sm font-medium text-gray-700 flex items-center space-x-3">
                <img src="{{ $user->getFirstMediaUrl('avatar', 'thumb') }}" class="w-[50px] h-[50px] rounded-full object-cover border" alt="">
                <input type="file" name="avatar" id="avatar">
            </label>
            
            
            <x-form.error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-form.label for="name" :value="__('Name')" />
            <x-form.input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-form.error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-form.label for="email" :value="__('Email')" />
            <x-form.input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-form.error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-form.label for="phone" :value="__('Phone')" />
            <x-form.input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" autofocus autocomplete="phone" />
            <x-form.error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div class="flex items-center gap-4">
            <x-buttons.primary>{{ __('Save') }}</x-buttons.primary>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
