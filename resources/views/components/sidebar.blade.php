<div x-cloak :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity  bg-black opacity-50 lg:hidden"></div>
    
<div x-cloak :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="h-dvh lg:h-full fixed inset-y-0 left-0 z-30 w-full sm:w-72 xl:w-96 transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0 bg-gray-100 border-r" >
    <div class="flex-1 flex flex-col overflow-hidden h-full">
		<div class="justify-between flex items-center p-4 space-x-4 bg-gray-100 z-40 md:hidden">
			<x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
			<button @click="sidebarOpen = false" class="text-gray-500 focus:outline-none lg:hidden">
				<svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</button>
		</div>

		<nav class="flex-1 overflow-y-auto">
			{{ $slot }}
		</nav>
	</div>
</div>