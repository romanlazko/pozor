<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Language') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your system language.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.updateLang') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-form.select name="lang">
                <option @selected($user->lang == 'ru') value="ru">RU</option>
                <option @selected($user->lang == 'en') value="en">EN</option>
                <option @selected($user->lang == 'cz') value="cz">CZ</option>
            </x-form.select>
        </div>
        <x-buttons.primary>{{ __('Save') }}</x-buttons.primary>
    </form>
</section>