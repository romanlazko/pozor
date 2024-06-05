<form action="{{ route('locale') }}" method="POST" class="block">
    @csrf
    <select name="locale" onchange="this.form.submit();" class="py-0 w-min bg-white border-gray-100 rounded-xl shadow-xl">
        <option @selected(app()->getLocale() == 'cs') value="cs">Czech</option>
        <option @selected(app()->getLocale() == 'ru') value="ru">Русский</option>
        <option @selected(app()->getLocale() == 'en') value="en">English</option>
    </select>
</form>