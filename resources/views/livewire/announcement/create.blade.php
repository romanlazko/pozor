<form wire:submit.prevent="create" class="w-full max-w-2xl mx-auto">
    {{-- @dump($data['attributes']['salary'] ?? []) --}}
    {{ $this->form }}
</form>
