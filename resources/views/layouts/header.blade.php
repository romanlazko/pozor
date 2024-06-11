<header class="flex items-center justify-between bg-white space-x-3 h-12 max-w-7xl m-auto">
	<div class="flex-1 items-center justify-start hidden lg:flex space-x-6">
		<a href="{{ route('announcement.index') }}">
			<x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
		</a>
		<x-locale/>
	</div>

	<div class="flex items-center space-x-3">
		@auth
			<a href="{{ route('profile.announcement.wishlist') }}" class="text-gray-500 hover:text-indigo-700 relative">
				<i class="fa-solid fa-heart"></i>
			</a>
			<a href="{{ route('profile.message.index') }}" class="text-gray-500 hover:text-indigo-700 relative">
				{{-- <i class="fa-solid fa-comments"></i>
				@if (auth()->user()?->unreadMessagesCount > 0)
					<p class="absolute text-[8px] text-white w-3 h-3 rounded-full bg-red-500 top-3 text-center content-center items-center">{{ auth()->user()->unreadMessagesCount }}</p>
				@endif --}}
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
			{{ __("Create announcement") }}
		</x-a-buttons.create>
	</div>
	
	
	<div class="flex items-center space-x-3">
		<div x-data="{ dropdownOpen: false }"  class="relative">
			<button @click="dropdownOpen = ! dropdownOpen" class="flex text-gray-500 hover:text-indigo-700">
				<i class="fa-solid fa-gear text-lg"></i>
			</button>

			<div x-cloak x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full"></div>

			<x-profile-nav x-cloak x-show="dropdownOpen" class="absolute right-0 z-20 mt-2 p-0 overflow-hidden bg-white rounded-md shadow-xl border"/>
		</div>
	</div>
</header>