<div class="w-full">
    <div class="w-full grid grid-cols-3 gap-2 mb-2">
        @foreach ($photos as $index => $photo)
            <div class="relative w-full aspect-square" wire:click="deletePhoto({{ $index }})">
                <button class="absolute text-2xl text-red-600 hover:scale-105 hover:text-red-500 bottom-0 right-0 mr-1">
                    <i class="fa-solid fa-circle-xmark bg-white rounded-full"></i>
                </button>
                <img class="w-full h-full object-cover rounded-lg border-2 hover:border-indigo-600" src="{{ $photo->temporaryUrl() }}">
            </div>
        @endforeach
    </div>
    
    <input id="photos" class="hidden" type="file" wire:model.live="photos" multiple>

    <label for="photos" class="w-full border-2 block p-6 rounded-lg text-center hover:bg-gray-100 hover:border-indigo-600 cursor-pointer">
        <i class="fa-solid fa-file-image"></i>
        Add photos
    </label>
    <x-form.error class="mt-1" :messages="$error"/>
</div>
