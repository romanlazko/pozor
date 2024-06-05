<section>
    <header class="flex space-x-6">
        <form method="post" action="{{ route('profile.updateAvatar') }}" enctype="multipart/form-data" onsubmit="event.target.submit(); return false;">
            @csrf
            @method('patch')
            <label for="avatar" class="block w-14 h-14 min-w-14 min-h-14 rounded-full border-2 hover:border-indigo-700 overflow-hidden">
                <img src="{{ $user->getFirstMediaUrl('avatar', 'thumb') }}" class="object-cover " alt="">
                <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*" onchange="event.target.form.submit();">
            </label>
            <x-form.error class="mt-2" :messages="$errors->get('avatar')" />
        </form>
        <div>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Profile Information') }}
            </h2>
    
            <p class="mt-1 text-sm text-gray-600">
                {{ __("Update your account's profile information.") }}
            </p>
        </div>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-form.label for="name" :value="__('Name')" :required="true"/>
            <x-form.input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-form.error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-form.label for="email" :value="__('Email')" :required="true"/>
            <x-form.input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-form.error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-form.label for="phone" :value="__('Phone')" :required="true"/>
            <x-form.input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" autofocus autocomplete="phone" />
            <x-form.error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            {{-- <p class="mt-1 text-sm text-gray-600">
                {{ __('Select languages you speak') }}
            </p> --}}
            <x-form.label :value="__('Select languages you speak')" :required="true"/>
            <div class="w-full flex space-x-3 items-center p-3 border rounded-md mt-1">
                <x-form.label for="en" class="items-center flex space-x-2">
                    <span class="text-indigo-700">
                        {{ __("English") }}
                    </span>
                    <x-form.checkbox id="en" name="lang[]" value="en" :checked="in_array('en', auth()?->user()?->lang ?? [])"/>
                </x-form.label>
                <x-form.label for="ru" class="items-center flex space-x-2">
                    <span class="text-indigo-700">
                        {{ __("Русский") }}
                    </span>
                    <x-form.checkbox id="ru" name="lang[]" value="ru" :checked="in_array('ru', auth()?->user()?->lang ?? [])"/>
                </x-form.label>
                <x-form.label for="cz" class="items-center flex space-x-2">
                    <span class="text-indigo-700">
                        {{ __("Czech") }}
                    </span>
                    <x-form.checkbox id="cz" name="lang[]" value="cz" :checked="in_array('cz', auth()?->user()?->lang ?? [])"/>
                </x-form.label>
            </div>
            
            <x-form.error class="mt-2" :messages="$errors->get('lang')" />
        </div>

        <div class="flex items-center gap-4">
            <x-buttons.primary>{{ __('Save') }}</x-buttons.primary>
        </div>
    </form>
</section>
