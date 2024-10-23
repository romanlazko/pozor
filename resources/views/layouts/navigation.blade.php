<header class="flex items-center justify-between bg-gray-900 space-x-6 h-12 max-w-7xl m-auto z-50">
	<div class="flex items-center justify-start space-x-6 text-sm">
		<a href="{{ route('home') }}">
			<x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
		</a>
	</div>

	<div class="md:flex w-full justify-between hidden">
		<div class="flex items-center justify-end space-x-3 text-white text-sm">
			<a href="" class="text-white hover:text-indigo-700 relative">
				{{ __('navigation.about_us') }}
			</a>

			<a href="" class="text-white hover:text-indigo-700 relative">
				{{ __('navigation.privacy') }}
			</a>

			<a href="" class="text-white hover:text-indigo-700 relative">
				{{ __('navigation.contacts') }}
			</a>
		</div>

		<div class="flex items-center space-x-6 text-white">
			@auth
				<a href="{{ route('profile.wishlist') }}" class="text-white hover:text-indigo-700 relative">
					<x-heroicon-s-heart class="size-5"/>
				</a>
				<button @click="$dispatch('open-chat')" class="text-white hover:text-indigo-700 relative">
					<x-heroicon-s-chat-bubble-left-right class="size-5"/>
					<div class="relative leading-3">
						@if ($unreadMessagesCount > 0)
							<p class="absolute text-[8px] text-white w-3 h-3 rounded-full bg-red-500 top-3 text-center content-center items-center">{{ $unreadMessagesCount }}</p>
						@endif
					</div>
				</button>
				<a href="{{ route('profile.edit') }}" class="text-white hover:text-indigo-700 relative">
					<x-heroicon-s-user class="size-5"/>
				</a>
			@else
				<a href="{{ route('register') }}" class="hover:text-indigo-700">{{ __("navigation.register") }}</a>
				<a href="{{ route('login') }}" class="hover:text-indigo-700">{{ __("navigation.login") }}</a>
			@endauth
			
			<x-a-buttons.create href="{{ route('announcement.create') }}" class="">
				{{ __("navigation.create_new") }}
			</x-a-buttons.create>
		</div>
	</div>

	<div>

	</div>
	<div class="flex items-center space-x-2 w-min">
		<x-locale class="md:w-min w-full"/>

		<div class="flex items-center md:hidden relative">
			<div x-data="{ dropdownOpen: false }" class="relative">
				<button @click="dropdownOpen = ! dropdownOpen" class="flex text-white hover:text-indigo-700">
					<x-heroicon-c-bars-3-bottom-right class="size-5"/>
				</button>
	
				<div x-cloak :class="dropdownOpen ? 'block' : 'hidden'" @click="dropdownOpen = false" class="fixed inset-0 z-40 transition-opacity  bg-black opacity-50"></div>
	
				<div x-cloak x-show="dropdownOpen" class="absolute right-0 z-50 mt-2 p-0 overflow-hidden bg-white rounded-md shadow-xl border">
					<x-profile-nav>
						<hr>
						<a href="{{ route('profile.wishlist') }}" 
							@class([
								'flex text-gray-700 hover:text-indigo-600 whitespace-nowrap items-center space-x-3 text-sm', 
								'text-indigo-600' => request()->routeIs('profile.wishlist')
							])
						>
							<span class="font-medium">
								{{ __('navigation.about_us') }}
							</span>
						</a>
						<a href="{{ route('profile.wishlist') }}" 
							@class([
								'flex text-gray-700 hover:text-indigo-600 whitespace-nowrap items-center space-x-3 text-sm', 
								'text-indigo-600' => request()->routeIs('profile.wishlist')
							])
						>
							<span class="font-medium">
								{{ __('navigation.privacy') }}
							</span>
						</a>
						<a href="{{ route('profile.wishlist') }}" 
							@class([
								'flex text-gray-700 hover:text-indigo-600 whitespace-nowrap items-center space-x-3 text-sm', 
								'text-indigo-600' => request()->routeIs('profile.wishlist')
							])
						>
							<span class="font-medium">
								{{ __('navigation.contacts') }}
							</span>
						</a>
					</x-profile-nav>
				</div>
			</div>
		</div>
	</div>
</header>