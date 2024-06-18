@props(['announcement_id'])

@auth
    <form action="{{ route('profile.message.store') }}" method="POST" class="space-y-2">
        @csrf
        <input type="hidden" name="announcement_id" value="{{ $announcement_id }}">
        <livewire:components.textarea :rows="6"/>
        <x-buttons.primary>
            {{ __("Send") }}
        </x-buttons.primary>
    </form>
@else
    <x-a-buttons.primary href="{{ route('login') }}">
        {{ __("Login for meassaging") }}
    </x-a-buttons.primary>
@endauth