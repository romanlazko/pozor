<header class="flex items-center justify-between bg-gray-900 space-x-6 h-12 max-w-7xl m-auto z-50">
	<div class="flex items-center justify-start space-x-6 text-sm">
		<a href="{{ route('announcement.index') }}">
			<x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
		</a>
	</div>

	<div class="md:flex w-full justify-between hidden">
		<div class="flex items-center justify-end space-x-3 text-white text-sm">
			<a href="" class="text-white hover:text-indigo-700 relative">
				{{ __('About us') }}
			</a>

			<a href="" class="text-white hover:text-indigo-700 relative">
				{{ __('Privacy') }}
			</a>

			<a href="" class="text-white hover:text-indigo-700 relative">
				{{ __('Contact') }}
			</a>
		</div>

		<div class="flex items-center space-x-6 text-white">
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
				<a href="{{ route('profile.edit') }}" class="text-white hover:text-indigo-700 relative">
					<i class="fa-solid fa-user"></i> 
				</a>
			@else
				<a href="{{ route('register') }}" class="hover:text-indigo-700">Register</a>
				<a href="{{ route('login') }}" class="hover:text-indigo-700">Login</a>
			@endauth
			
			<x-a-buttons.create href="{{ route('profile.announcement.create') }}" class="">
				{{ __("Create New") }}
			</x-a-buttons.create>
		</div>
	</div>

	<x-locale class="lg:w-min w-full"/>

	<div class="flex items-center space-x-3 lg:hidden relative">
		<div x-data="{ dropdownOpen: false }" class="relative">
			<button @click="dropdownOpen = ! dropdownOpen" class="flex text-white hover:text-indigo-700">
				<i class="fa-solid fa-bars"></i>
			</button>

			<div x-cloak :class="dropdownOpen ? 'block' : 'hidden'" @click="dropdownOpen = false" class="fixed inset-0 z-40 transition-opacity  bg-black opacity-50"></div>

			<div x-cloak x-show="dropdownOpen" class="absolute right-0 z-50 mt-2 p-0 overflow-hidden bg-white rounded-md shadow-xl border">
				<x-profile-nav>
					<hr>
					<a href="{{ route('profile.announcement.wishlist') }}" @class(['flex text-gray-700 hover:text-indigo-600 whitespace-nowrap items-center space-x-3 text-sm', 'text-indigo-600' => request()->routeIs('profile.announcement.wishlist')])>
						<span class="font-medium">{{ __('About us') }}</span>
					</a>
					<a href="{{ route('profile.announcement.wishlist') }}" @class(['flex text-gray-700 hover:text-indigo-600 whitespace-nowrap items-center space-x-3 text-sm', 'text-indigo-600' => request()->routeIs('profile.announcement.wishlist')])>
						<span class="font-medium">{{ __('Privacy') }}</span>
					</a>
					<a href="{{ route('profile.announcement.wishlist') }}" @class(['flex text-gray-700 hover:text-indigo-600 whitespace-nowrap items-center space-x-3 text-sm', 'text-indigo-600' => request()->routeIs('profile.announcement.wishlist')])>
						<span class="font-medium">{{ __('Contact') }}</span>
					</a>
				</x-profile-nav>
				
			</div>
			
		</div>
	</div>
</header>