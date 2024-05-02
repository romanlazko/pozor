<header class="flex items-center justify-between px-2 md:px-4 py-1 bg-white border-b border-gray-300 space-x-3">
	<div class="flex-1 items-center justify-start hidden lg:flex">
		<a href="{{ route('announcement.index') }}">
			<x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
		</a>
		
	</div>

	<div class="flex items-center space-x-2">
		@guest
			<a href="{{ route('register') }}" class="hover:text-indigo-700">Register</a>
			<a href="{{ route('login') }}" class="hover:text-indigo-700">Login</a>
		@endguest
		
		<x-a-buttons.create href="{{ route('profile.announcement.create') }}" class="">
			{{ __("Create announcement") }}
		</x-a-buttons.create>
	</div>
	
	
	<div class="flex items-center space-x-3">
		<div x-data="{ dropdownOpen: false }"  class="relative">
			<button @click="dropdownOpen = ! dropdownOpen" class="flex text-gray-500 hover:text-indigo-700">
				<i class="fa-solid fa-gear text-lg"></i>
			</button>

			<div x-cloak x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full"></div>

			<div x-cloak x-show="dropdownOpen" class="absolute right-0 z-20 mt-2 overflow-hidden bg-white rounded-md shadow-xl border">
				
				<a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">
					<div class="whitespace-nowrap">
						<div class="font-medium text-base">{{ __("Profile") }}</div>
					</div>
				</a>
				<a href="{{ route('profile.announcement.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">
					<div class="whitespace-nowrap">
						<div class="font-medium text-base">{{ __("Announcements") }}</div>
					</div>
				</a>
				<form method="POST" action="{{ route('logout') }}">
					@csrf
					<button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white w-full text-left whitespace-nowrap">
						{{ __('Log Out') }}
					</button>
				</form>
			</div>
		</div>
	</div>
</header>