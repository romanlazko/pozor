<header class="flex items-center justify-between bg-gray-900 space-x-3 h-12 max-w-7xl m-auto z-50">
	<div class="flex-1 items-center justify-start flex space-x-6">
		<a href="{{ route('announcement.index') }}">
			<x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
		</a>
	</div>

	<div class="hidden lg:flex items-center space-x-3 text-white">
		@auth
			<a href="{{ route('profile.announcement.wishlist') }}" class="text-white hover:text-indigo-700 relative">
				<i class="fa-solid fa-heart"></i>
			</a>
			<a href="{{ route('profile.message.index') }}" class="text-white hover:text-indigo-700 relative">
				<div class="relative leading-3">
					@if ($unreadMessagesCount > 0)
						<p class="absolute text-[8px] text-white w-3 h-3 rounded-full bg-red-500 top-3 text-center content-center items-center">{{ $unreadMessagesCount }}</p>
					@endif
					<i class="fa-solid fa-comments w-4"></i>
				</div>
			</a>
		@else
			<a href="{{ route('register') }}" class="hover:text-indigo-700">Register</a>
			<a href="{{ route('login') }}" class="hover:text-indigo-700">Login</a>
		@endauth
		
		<x-a-buttons.create href="{{ route('profile.announcement.create') }}" class="">
			{{ __("Create New") }}
		</x-a-buttons.create>
	</div>
	
	
	<div class="flex items-center space-x-3 z-50">
		<div x-data="{ dropdownOpen: false }"  class="relative z-50">
			<button @click="dropdownOpen = ! dropdownOpen" class="flex text-white hover:text-indigo-700">
				<i class="fa-solid fa-gear text-lg"></i>
			</button>

			<div x-cloak x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full"></div>

			<x-profile-nav x-cloak x-show="dropdownOpen" class="absolute right-0 z-50 mt-2 p-0 overflow-hidden bg-white rounded-md shadow-xl border"/>
		</div>
	</div>
</header>