@props(['medias' => [], 'h' => 500, 'thumb' => true])

<div x-data="{
        photos: {{ $medias->map(fn ($media) => [
            'srcset' => $media->getSrcset('responsive-images'),
            'placeholder' => $media->responsiveImages('responsive-images')->getPlaceholderSvg(),
            'thumb' => $media->getUrl('thumb'),
        ]) }},
        current: 0,
        prev() {
            this.current = (this.current - 1 + this.photos.length) % this.photos.length;
        },
        next() {
            this.current = (this.current + 1) % this.photos.length;
        },
        touchStartX: null,
        touchEndX: null,
        swipeThreshold: 50,
        handleTouchStart(event) {
            this.touchStartX = event.touches[0].clientX
        },
        handleTouchMove(event) {
            this.touchEndX = event.touches[0].clientX
        },
        handleTouchEnd() {
            if(this.touchEndX){
                if (this.touchStartX - this.touchEndX > this.swipeThreshold) {
                    this.next()
                }
                if (this.touchStartX - this.touchEndX < -this.swipeThreshold) {
                    this.next()
                }
                this.touchStartX = null
                this.touchEndX = null
            }
        },
    }"
    class="overflow-hidden flex flex-col "
    style="height: {{ $h }}px"
>
    <div class="relative overflow-hidden flex-1">
        {{-- <img x-bind:src="photos[current]['placeholder']" alt="" class="absolute z-0 inset-0 bg-cover bg-center object-cover border-none h-full w-full"/> --}}
        <div class="w-full m-auto items-center z-30 h-full bg-black">
            <div class="flex relative h-full justify-center items-center">
                <div class="absolute z-20 left-0 content-center h-full flex items-center px-1">
                    <button x-on:click="prev" :class="{ 'hidden': photos.length < 2 }" class="m-auto whitespace-nowrap items-center cursor-pointer grid w-8 h-8 " aria-label="previous-photo">
                        <div class="bg-gray-50 hover:bg-gray-200 aspect-square w-4 h-4 md:w-8 md:h-8 rounded-full content-center items-center m-auto grid">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </div>
                    </button>
                </div>

                <img x-on:touchstart="handleTouchStart($event)" x-on:touchmove="handleTouchMove($event)" x-on:touchend="handleTouchEnd()" x-bind:srcset="photos[current]['srcset']" x-bind:src="photos[current]['placeholder']" onload="window.requestAnimationFrame(function(){if(!(size=getBoundingClientRect().width))return;onload=null;sizes=Math.ceil(size/window.innerWidth*100)+'vw';});" sizes="1px" alt="" class="object-contain w-full h-full" loading="lazy">
                
                <div class="absolute z-20 right-0 content-center h-full flex items-center px-1">
                    <button x-on:click="next" :class="{ 'hidden': photos.length < 2 }" class="m-auto whitespace-nowrap items-center cursor-pointer grid w-8 h-8" aria-label="next-photo">
                        <div class="bg-gray-50 hover:bg-gray-200 aspect-square w-4 h-4 md:w-8 md:h-8 rounded-full content-center items-center m-auto grid">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if ($thumb)
        <div class="flex m-auto overflow-x-auto z-20 py-2 px-3">
            <template x-for="(photo, index) in photos" :key="index" class="bg-gray-200 w-16 h-16">
                <img x-bind:src="photo['thumb']" class="bg-gray-200 w-16 h-16 border-2 rounded-lg mx-2 hover:border-indigo-400"
                    :class="{ 'border-indigo-700': index === current, 'border-transparent': index !== current }"
                    x-on:click="current = index"
                >
            </template>
        </div>
    @endif
</div>