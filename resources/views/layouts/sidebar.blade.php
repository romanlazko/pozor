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
			<x-dropdown-nav-link :active="request()->routeIs('admin.announcement.*')">
				<x-slot name="trigger">
					{{ __('Announcements') }}
				</x-slot>
				<x-responsive-nav-link href="{{ route('admin.announcement.moderation') }}" :active="request()->routeIs('admin.announcement.moderation')">
					{{ __('Moderation') }}
				</x-responsive-nav-link>
				<x-responsive-nav-link href="{{ route('admin.announcement.announcements') }}" :active="request()->routeIs('admin.announcement.announcements')">
					{{ __('All announcements') }}
				</x-responsive-nav-link>
			</x-dropdown-nav-link>
		@endhasrole

		@hasrole('super-duper-admin')
			<x-dropdown-nav-link :active="request()->routeIs('admin.telegram.*')">
				<x-slot name="trigger">
					{{ __('Telegram') }}
				</x-slot>
				<x-responsive-nav-link href="{{ route('admin.telegram.bots') }}" :active="request()->routeIs('admin.telegram.bots')">
					{{ __('Bots') }}
				</x-responsive-nav-link>
				@foreach (\App\Models\TelegramBot::select('first_name', 'id')->get() as $bot)
					<x-dropdown-nav-link :active="request()->routeIs('admin.telegram.chats', $bot->id) || request()->routeIs('admin.telegram.logs', $bot->id) || request()->routeIs('admin.telegram.channels', $bot->id)">
						<x-slot name="trigger">
							{{ $bot->first_name }}
						</x-slot>
						<x-responsive-nav-link href="{{ route('admin.telegram.chats', $bot->id) }}" :active="request()->routeIs('admin.telegram.chats', $bot->id)">
							{{ __('Ctats') }}
						</x-responsive-nav-link>
						<x-responsive-nav-link href="{{ route('admin.telegram.channels', $bot->id) }}" :active="request()->routeIs('admin.telegram.channels', $bot->id)">
							{{ __('Channels') }}
						</x-responsive-nav-link>
						<x-responsive-nav-link href="{{ route('admin.telegram.logs', $bot->id) }}" :active="request()->routeIs('admin.telegram.logs', $bot->id)">
							{{ __('Logs') }}
						</x-responsive-nav-link>
					</x-dropdown-nav-link>
				@endforeach
			</x-dropdown-nav-link>
		@endhasrole

		@hasrole('super-duper-admin')
			<x-dropdown-nav-link :active="request()->routeIs('admin.users.*')">
				<x-slot name="trigger">
					{{ __('Users') }}
				</x-slot>
				<x-responsive-nav-link href="{{ route('admin.users.users') }}" :active="request()->routeIs('admin.users.users')">
					{{ __('Users') }}
				</x-responsive-nav-link>
				{{-- <x-responsive-nav-link href="{{ route('admin.users') }}" :active="request()->routeIs('admin.users')">
					{{ __('Rolles') }}
				</x-responsive-nav-link>
				<x-responsive-nav-link href="{{ route('admin.users') }}" :active="request()->routeIs('admin.users')">
					{{ __('Permissions') }}
				</x-responsive-nav-link> --}}
			</x-dropdown-nav-link>
		@endhasrole

		@hasrole('super-duper-admin')
			<x-dropdown-nav-link :active="request()->routeIs('admin.setting.*')">
				<x-slot name="trigger">
					{{ __('Settings') }}
				</x-slot>

				<x-responsive-nav-link href="{{ route('admin.setting.categories') }}" :active="request()->routeIs('admin.setting.categories')">
					{{ __('Category') }}
				</x-responsive-nav-link>
				<x-responsive-nav-link href="{{ route('admin.setting.attributes') }}" :active="request()->routeIs('admin.setting.attributes')">
					{{ __('Attribute') }}
				</x-responsive-nav-link>
				<x-responsive-nav-link href="{{ route('admin.setting.sections') }}" :active="request()->routeIs('admin.setting.sections')">
					{{ __('Sections') }}
				</x-responsive-nav-link>
				<x-responsive-nav-link href="{{ route('admin.setting.sortings') }}" :active="request()->routeIs('admin.setting.sortings')">
					{{ __('Sortings') }}
				</x-responsive-nav-link>
			</x-dropdown-nav-link>
		@endhasrole

		@hasrole('super-duper-admin')
			<x-responsive-nav-link href="{{ route('admin.logs') }}" :active="request()->routeIs('admin.logs')">
				{{ __('Logs') }}
			</x-responsive-nav-link>
		@endhasrole

		<hr>
		@hasrole('super-duper-admin')
			<x-responsive-nav-link href="{{ route('home') }}">
				{{ __('Back to user') }}
			</x-responsive-nav-link>
		@endhasrole
    </nav>
</div>