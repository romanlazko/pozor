{{-- @props(['medias' => [], 'h' => null, 'thumb' => true])

<div x-data="{
        photos: {{ $medias->map(fn ($media) => [
            'srcset' => $media->getSrcset('responsive-images'),
            'placeholder' => $media->responsiveImages('responsive-images')->getPlaceholderSvg(),
            'thumb' => $media->getUrl('thumb'),
        ]) }},
        current: 0,
        activeClass: '',
        active: true,
        prev() {
            this.activeClass = 'translate-x-full';

            setTimeout(() => {
                this.activeClass = 'translate-x-full hidden';
            }, 300);

            setTimeout(() => {
                this.current = (this.current - 1 + this.photos.length) % this.photos.length;
                this.activeClass = '-translate-x-full hidden';
            }, 300);

            setTimeout(() => {
                this.activeClass = '-translate-x-full';
            }, 310);

            setTimeout(() => {
                this.activeClass = 'translate-x-0 ';
            }, 330);
        },
        next() {
            this.activeClass = '-translate-x-full';

            setTimeout(() => {
                this.activeClass = '-translate-x-full hidden';
            }, 300);

            setTimeout(() => {
                this.current = (this.current + 1) % this.photos.length;
                this.activeClass = 'translate-x-full hidden';
            }, 300);

            setTimeout(() => {
                this.activeClass = 'translate-x-full';
            }, 310);

            setTimeout(() => {
                this.activeClass = 'translate-x-0 ';
            }, 330);
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
    @class(["overflow-hidden flex flex-col", 'h-[200px] md:h-[300px]' => !$h])
    style="height: {{ $h }}px"
>
    <div class="relative overflow-hidden flex-1">
        <div class="w-full m-auto items-center z-30 h-full bg-black lg:rounded-2xl overflow-hidden">
            <div class="flex relative h-full justify-center items-center">
                <div class="absolute z-20 left-0 content-center h-full flex items-center px-1">
                    <button x-on:click="prev" :class="{ 'hidden': photos.length < 2 }" class="m-auto whitespace-nowrap items-center cursor-pointer grid w-8 h-8 " aria-label="previous-photo">
                        <div class="bg-gray-50 hover:bg-gray-200 aspect-square w-4 h-4 md:w-8 md:h-8 rounded-full content-center items-center m-auto grid">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </div>
                    </button>
                </div>

                <img 
                    x-on:touchstart="handleTouchStart($event)" 
                    x-on:touchmove="handleTouchMove($event)" 
                    x-on:touchend="handleTouchEnd()" 
                    x-bind:srcset="photos[current]['srcset']" 
                    x-bind:src="photos[current]['placeholder']"
                    :class="{ [activeClass]: true }"
                    onload="window.requestAnimationFrame(function(){if(!(size=getBoundingClientRect().width))return;onload=null;sizes=Math.ceil(size/window.innerWidth*100)+'vw';});" 
                    sizes="1px" 
                    alt=""
                    class="object-contain w-full h-full transition duration-300 ease-in-out" 
                    loading="lazy"
                >
                
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
        <div class="flex m-auto overflow-x-auto z-10 py-2 px-3">
            <template x-for="(photo, index) in photos" :key="index" class="bg-gray-200 w-16 h-16">
                <img x-bind:src="photo['thumb']" class="bg-gray-200 w-16 h-16 border-2 rounded-lg mx-2 hover:border-indigo-400"
                    :class="{ 'border-indigo-700': index === current, 'border-transparent': index !== current }"
                    x-on:click="current = index"
                >
            </template>
        </div>
    @endif
</div> --}}

{{-- @props(['medias' => [], 'h' => null, 'thumb' => true])

<div
    @class(["overflow-hidden flex flex-col", 'h-[200px] md:h-[300px]' => !$h])
    style="height: {{ $h }}px"
>
    <div class="relative overflow-hidden flex-1">
        <div class="w-full m-auto items-center z-30 h-full bg-black lg:rounded-2xl overflow-hidden">
            <div class="flex relative h-full justify-center items-center">
                <div class="absolute z-20 left-0 content-center h-full flex items-center px-1">
                    <button x-on:click="prev" :class="{ 'hidden': photos.length < 2 }" class="m-auto whitespace-nowrap items-center cursor-pointer grid w-8 h-8 " aria-label="previous-photo">
                        <div class="bg-gray-50 hover:bg-gray-200 aspect-square w-4 h-4 md:w-8 md:h-8 rounded-full content-center items-center m-auto grid">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </div>
                    </button>
                </div>

                <template x-for="(photo, index) in photos" :key="index" class="bg-gray-200 w-16 h-16">
                    <img 
                        x-on:touchstart="handleTouchStart($event)" 
                        x-on:touchmove="handleTouchMove($event)" 
                        x-on:touchend="handleTouchEnd()" 
                        x-bind:srcset="photo['srcset']"
                        x-bind:src="photo['placeholder']"
                        :class="{ 'w-0': index !== current , 'w-full translate-x-0': index === current, 'translate-x-10': current > oldCurrent, }"
                        x-on:load="updateSize($event.target)"
                        :sizes="sizes"
                        alt="" 
                        class="object-contain h-full transition duration-500 ease-in-out" 
                        loading="lazy"
                    >
                </template>
                
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
        <div class="flex m-auto overflow-x-auto z-10 py-2 px-3">
            <template x-for="(photo, index) in photos" :key="index" class="bg-gray-200 w-16 h-16">
                <img x-bind:src="photo['thumb']" class="bg-gray-200 w-16 h-16 border-2 rounded-lg mx-2 hover:border-indigo-400"
                    :class="{ 'border-indigo-700': index === current, 'border-transparent': index !== current }"
                    x-on:click="current = index"
                >
            </template>
        </div>
    @endif
</div> --}}

@props(['medias' => [], 'h' => null, 'thumb' => true])

<div 
    class="w-full mx-auto overflow-hidden flex flex-col" 
    style="height: {{ $h }}px"
    x-data="slider({{ $medias->map(fn ($media) => [
        'srcset' => $media->getSrcset('responsive-images'),
        'placeholder' => $media->responsiveImages('responsive-images')->getPlaceholderSvg(),
        'thumb' => $media->getUrl('thumb'),
    ]) }})"
>
    <!-- Слайдер -->
    <div class="relative overflow-hidden flex-1 bg-black lg:rounded-2xl aspect-square" @touchstart="handleTouchStart($event)" @touchend="handleTouchEnd($event)" @touchmove="handleTouchMove($event)" >
        <div class="w-full m-auto items-center z-30 h-full overflow-hidden">
            <div class="flex transition-transform duration-500 h-full items-center" :style="'transform: translateX(-' + activeIndex * 100 + '%)'">
                <template x-for="(photo, index) in photos" :key="index">
                    <div class="w-full h-full flex-shrink-0" >
                        <div class="h-full">
                            <img 
                                :src="photo.placeholder"
                                :srcset="photo.srcset"
                                :alt="'Slide ' + (index + 1)"
                                sizes="1px"
                                onload="window.requestAnimationFrame(function(){if(!(size=getBoundingClientRect().width))return;onload=null;sizes=Math.ceil(size/window.innerWidth*100)+'vw';});" 
                                class="object-contain h-full m-auto" 
                                loading="lazy"
                            >
                        </div>
                    </div>
                </template>
            </div>
            <div class="absolute inset-0 flex justify-between items-center px-3" :class="{ 'hidden': photos.length < 2 }">
                <button @click.prevent="prevSlide()" @dblclick.prevent class="bg-gray-800 bg-opacity-50 lg:hover:bg-opacity-90 text-white p-2 rounded-full opacity-30 hover:opacity-100 lg:opacity-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button @click.prevent="nextSlide()" @dblclick.prevent class="bg-gray-800 bg-opacity-50 lg:hover:bg-opacity-90 text-white p-2 rounded-full opacity-30 hover:opacity-100 lg:opacity-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Thumbnails -->
    @if ($thumb)
    <div class="w-full flex justify-center">
        <div class="overflow-x-auto min-h-20 flex mt-4 m-auto" x-ref="thumbnailContainer">
            <template x-for="(photo, index) in photos" :key="index">
                <img :src="photo.thumb" @click="setActiveSlide(index); centerThumbnail(index)" 
                    :class="{'ring-2 ring-indigo-700': activeIndex === index, 'ring-1': activeIndex !== index}" 
                    class="w-16 h-16 min-h-16 min-w-16 object-cover m-1 cursor-pointer rounded-lg ring-gray-200 hover:ring-indigo-400">
            </template>
        </div>
    </div>
        
    @endif
</div>

<script>
    function slider(photos) {
        return {
            photos: photos,
            activeIndex: 0,
            touchStartX: 0,
            touchStartY: 0,
            touchEndX: 0,
            touchEndY: 0,
            touchMoveX: 0,
            touchMoveY: 0,
            touchStarted: false,
            horizontalThreshold: 70, // Порог горизонтальной прокрутки
            verticalThreshold: 60,
            ratio: 0,
            nextSlide() {
                this.activeIndex = (this.activeIndex + 1) % this.photos.length;
                this.centerThumbnail(this.activeIndex);
            },
            prevSlide() {
                this.activeIndex = (this.activeIndex - 1 + this.photos.length) % this.photos.length;
                this.centerThumbnail(this.activeIndex);
            },
            setActiveSlide(index) {
                this.activeIndex = index;
                this.centerThumbnail(this.activeIndex);
            },
            handleTouchStart(event) {
                this.touchStartX = event.touches[0].screenX;
                this.touchStartY = event.touches[0].screenY;
                this.touchStarted = true;
            },

            handleTouchMove(event) {
                if (!this.touchStarted) return;

                this.touchMoveX = event.touches[0].screenX;
                this.touchMoveY = event.touches[0].screenY;

                const deltaX = Math.abs(this.touchMoveX - this.touchStartX);
                const deltaY = Math.abs(this.touchMoveY - this.touchStartY);
                const ratio = deltaX / deltaY;

                if (ratio > 1.5) {
                    event.preventDefault();
                } else {
                    this.touchStarted = false;
                }
            },

            handleTouchEnd(event) {
                if (!this.touchStarted) return;

                this.touchEndX = event.changedTouches[0].screenX;
                this.touchEndY = event.changedTouches[0].screenY;
                this.touchStarted = false;

                const deltaX = Math.abs(this.touchEndX - this.touchStartX);
                const deltaY = Math.abs(this.touchEndY - this.touchStartY);
                const ratio = deltaX / deltaY;

                if (ratio > 1.5 || deltaX > this.horizontalThreshold) {
                    if (this.touchEndX - this.touchStartX < 0) {
                        this.nextSlide();
                    } else if (this.touchEndX - this.touchStartX > 0) {
                        this.prevSlide();
                    }
                }
            },
            centerThumbnail(index) {
                const thumbnailContainer = this.$refs.thumbnailContainer;

                if (thumbnailContainer) {
                    const thumbnailWidth = thumbnailContainer.children[index].offsetWidth;
                    const containerWidth = thumbnailContainer.offsetWidth;
                    const scrollAmount = thumbnailContainer.children[index].offsetLeft - containerWidth / 2 + thumbnailWidth / 2;
                    thumbnailContainer.scrollTo({
                        left: scrollAmount,
                        behavior: 'smooth'
                    });
                }
                
            }
        }
    }
</script>