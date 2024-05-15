<div x-cloak :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity  bg-black opacity-50 lg:hidden"></div>
    
<div x-cloak :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="lg:mt-10 fixed inset-y-0 left-0 z-30 w-full sm:w-72 xl:w-96 transition duration-300 transform lg:translate-x-0 lg:inset-0 bg-gray-100 border-r" >
    <div class="flex-1 flex flex-col overflow-hidden h-full">
		<div class="justify-between flex items-center p-4 space-x-4 bg-gray-100 z-40 lg:hidden">
			<x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
			<button @click="sidebarOpen = false" class="text-gray-500 focus:outline-none lg:hidden">
				<i class="fa-solid fa-xmark text-2xl hover:text-gray-800"></i>
			</button>
		</div>

		<nav class="flex-1 overflow-y-auto h-full">
			{{ $slot }}
		</nav>
	</div>
</div>