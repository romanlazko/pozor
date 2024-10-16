
    
{{-- <div x-cloak :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-full sm:w-72 xl:w-96 transition duration-300 transform lg:translate-x-0 lg:inset-0 bg-gray-100 border-r" > --}}
<div {{ $attributes->merge(['class' => "flex-1 flex flex-col overflow-hidden lg:flex-none lg:overflow-visible lg:flex-row w-full"]) }}>
	<div class="justify-between flex items-center p-2 px-4 space-x-4 bg-gray-900 z-40 lg:hidden">
		<a href="{{ route('announcement.index') }}">
			
		</a>
		<button @click="sidebarOpen = false" class="text-gray-200 focus:outline-none lg:hidden">
			<i class="fa-solid fa-xmark text-2xl hover:text-gray-100"></i>
		</button>
	</div>

	<nav class="flex-1 overflow-y-auto h-full lg:flex-none lg:overflow-visible lg:flex-row w-full p-4">
		{{ $slot }}
	</nav>
</div>
{{-- </div> --}}