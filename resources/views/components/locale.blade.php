<form action="{{ route('locale') }}" method="POST" {{ $attributes->merge(['class' => 'block']) }}>
    @csrf
    <select name="locale" onchange="this.form.submit();" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-700 focus:ring focus:ring-indigo-700 focus:ring-opacity-50 w-full">
        <option @selected(app()->getLocale() == 'cs') value="cs">Czech</option>
        <option @selected(app()->getLocale() == 'ru') value="ru">Русский</option>
        <option @selected(app()->getLocale() == 'en') value="en">English</option>
    </select>
</form>