<div x-data="{
        photos: {{ $medias->map(fn($media) => $media->getUrl())->toJson() }},
        current: 0,
        prev() {
            this.current = (this.current - 1 + this.photos.length) % this.photos.length;
        },
        next() {
            this.current = (this.current + 1) % this.photos.length;
        },
    }"
    class="bg-white rounded-lg shadow-md overflow-hidden"
>
    <div class="relative bg-gray-200 overflow-hidden">
        <div class="absolute z-0 inset-0 bg-cover bg-center filter blur-2xl border-none h-full w-full"
            x-bind:style="'background-image: url('+ photos[current] +')'">
            <div class="bg-white opacity-60 h-full w-full"></div>
        </div>
        <div class="w-full m-auto items-center h-[500px] z-30">
            <div class="flex relative h-full justify-center items-center">
                <div class="absolute z-50 left-0 content-center h-full flex items-center px-1">
                    <button x-on:click="prev" class="m-auto whitespace-nowrap items-center cursor-pointer grid bg-gray-50 hover:bg-gray-200 aspect-square w-8 h-8 rounded-full content-center">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                </div>

                <img x-bind:src="photos[current]" alt="" class="object-contain w-full h-full">
                
                <div class="absolute z-50 right-0 content-center h-full flex items-center px-1">
                    <button x-on:click="next" class="m-auto whitespace-nowrap items-center cursor-pointer grid bg-gray-50 hover:bg-gray-200 aspect-square w-8 h-8 rounded-full content-center">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
        
    </div>

    <div class="flex m-auto w-full justify-center overflow-hidden z-30 py-2 px-3">
        <template x-for="(photo, index) in photos" :key="index">
            <img x-bind:src="photo" class="bg-gray-200 w-16 h-16 border-2 rounded-lg object-cover mx-2 hover:border-indigo-400"
                :class="{ 'border-indigo-700': index === current, 'border-transparent': index !== current }"
                x-on:click="current = index"
            >
        </template>
    </div>
</div>