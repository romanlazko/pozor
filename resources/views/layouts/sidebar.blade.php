<div x-cloak :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity  bg-black opacity-50 lg:hidden"></div>
    
<div x-cloak :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-full sm:w-72 overflow-y-auto transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0 bg-white">
    <div class="justify-between flex items-center p-4 space-x-4">
		<div class="flex items-center float-left overflow-hidden w-full">
			
		</div>
		<button @click="sidebarOpen = false" class="text-gray-500 focus:outline-none lg:hidden">
			<svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</button>
	</div>

    <nav class="space-y-3 px-2">
		@hasrole('super-duper-admin')
			<x-responsive-nav-link href="{{ route('admin.marketplace.announcement.index') }}">
				{{ __('Marketplace') }}
			</x-responsive-nav-link>
		@endhasrole
		@hasrole('super-duper-admin')
			<x-responsive-nav-link href="{{ route('admin.telegram_bot.index') }}">
				{{ __('telegram') }}
			</x-responsive-nav-link>
		@endhasrole
		@hasrole('super-duper-admin')
			<x-responsive-nav-link href="{{ route('marketplace.index') }}">
				{{ __('Back to user') }}
			</x-responsive-nav-link>
		@endhasrole
    </nav>
</div>