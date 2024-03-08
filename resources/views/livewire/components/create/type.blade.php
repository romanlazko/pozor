<div class="flex w-full justify-between items-center space-x-2 ">
    @foreach ($types as $type)
        <div wire:key="{{ $type }}" class="flex items-center w-full">
            <input wire:model.live="type" id="{{ $type }}" type="radio" class="peer/{{ $type }} hidden" name="type" value="{{ $type }}">
            <x-form.label for="{{ $type }}" class="w-full bg-white rounded-lg border-2 peer-checked/{{ $type }}:bg-indigo-600 peer-checked/{{ $type }}:border-indigo-600 peer-checked/{{ $type }}:text-white overflow-hidden p-4 hover:border-indigo-600 hover:bg-gray-100">
                {{ $type }}
            </x-form.label>
        </div>
    @endforeach
</div>
