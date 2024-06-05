<form method="POST" action="{{ route('logout') }}">
    @csrf
    <x-buttons.danger type="submit">
        {{ __('Log Out') }}
    </x-buttons.danger>
</form>