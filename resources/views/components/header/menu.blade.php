<div class="space-x-2 hidden lg:flex overflow-auto">
    {{ $slot }}
</div>
<div x-data="{ headerMenu: false }" class="lg:hidden items-center">
    <button @click="headerMenu = ! headerMenu" class=" hover:text-indigo-700">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    <div x-cloak x-show="headerMenu" @click.outside="headerMenu = false" @close.stop="headerMenu = false" class="absolute left-0 z-20 mt-2 overflow-hidden bg-white rounded-md shadow-xl border p-2 space-y-2">
        {{ $slot }}
    </div>
</div>