<div>
    @auth
        <form wire:submit="sendMessage" class="space-y-3">
            <x-form.textarea wire:model.live="message" placeholder="Write a message" required rows="6"/>
            <x-buttons.primary type="submit" class="w-full justify-center" x-on:click="$dispatch('close')" :disabled="!$message">
                <i class="fa-solid fa-comment mr-1"></i>
                Send message
            </x-buttons.primary>
        </form>
    @else
        <x-a-buttons.primary href="{{ route('login') }}">
            Login for meassaging
        </x-a-buttons.primary>
    @endauth
</div>
