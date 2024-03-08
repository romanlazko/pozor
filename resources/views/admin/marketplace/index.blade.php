<x-admin-layout>
    <x-slot name="header">
        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <div class="flex items-center" x-data>
            <h2 class="text-xl font-bold">
                Marketplace
            </h2>
            <form id="statusForm" action="{{ route('admin.marketplace.announcement.index') }}" >
                <select name="status" onchange="document.getElementById('statusForm').submit()" class="w-min border-none shadow-none focus:ring-0 text-indigo-700 text-lg fotn-light">
                    @foreach (App\Enums\Status::cases() as $status)
                        <option @selected(request('status', App\Enums\Status::await_moderation->value) == $status->value) value="{{ $status->value }}">{{ $status->trans() }}</option>
                    @endforeach
                </select>
                <select name="filter" onchange="document.getElementById('statusForm').submit()" class="w-min border-none shadow-none focus:ring-0 text-indigo-700 text-lg fotn-light">
                    @foreach (App\Enums\Filter::cases() as $filter)
                        <option @selected(request('filter') == $filter->name) value="{{ $filter->name }}">{{ $filter->value }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </x-slot>
    <div class="p-2 md:p-4 grid grid-cols-1 md:grid-cols-3 gap-3 gap-y-12">
        @foreach ($announcements as $announcement)
            <x-white-block class="p-0 h-min">
                <div class="p-1 flex items-center space-x-2">
                    <img src="{{ asset($announcement->user->avatar) }}" alt="" class="rounded-full w-8 h-8 aspect-square bg-red-600">
                    <p class="text-sm font-bold text-blue-700 hover:underline">
                        {{ $announcement->user->name }}
                    </p>
                </div>

                @if ($announcement->photos)
                    <div class="grid grid-cols-3 gap-1" >
                        @foreach($announcement->photos as $photo)
                            <div class="w-full h-full aspect-square">
                                <img src="{{ asset('storage/'.$photo->src) }}" class="flex object-cover w-full h-full rounded-sm">
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="space-y-3 p-3">
                    <div class="flex items-center justify-between">
                        <x-badge @class([
                            'border-orange-500 bg-orange-200 text-orange-700' => $announcement->status->isAwaitModeration(),
                            'border-green-500 bg-green-200 text-green-700' => $announcement->status->isPublished(),
                            'border-red-500 bg-red-200 text-red-700' => $announcement->status->isModerationNotPassed(),
                        ])>
                            {{ $announcement->status->trans() }}
                        </x-badge>
                        <p class="text-gray-500 text-sm">
                            {{ $announcement->updated_at->diffForHumans() }}
                        </p>
                    </div>
                    <div>
                        <h2 class="font-bold">
                            {{ $announcement->title }}
                        </h2>
                        <p class="text-sm">
                            {{ $announcement->price }} {{ $announcement->currency }}
                        </p>
                    </div>

                    <p class="text-sm text-gray-600">
                        {{ $announcement->caption }}
                    </p>
                    
                    <div>
                        <x-badge>
                            {{ $announcement->category?->name }}
                        </x-badge>
                        <x-badge>
                            {{ $announcement->subcategory?->name }}
                        </x-badge>
                    </div>

                    <hr>

                    <div class="w-full flex space-x-3">
                        @if ($announcement->status == App\Enums\Status::await_moderation OR $announcement->status == App\Enums\Status::moderation_not_passed)
                            <x-a-buttons.primary :href="route('admin.marketplace.announcement.approve', $announcement)">
                                {{ __("Approve") }}
                            </x-a-buttons.primary>
                            <x-a-buttons.secondary>
                                {{ __("Reject") }}
                            </x-a-buttons.secondary>
                        @endif

                        @if ($announcement->status == App\Enums\Status::moderation_passed) 
                            <x-a-buttons.primary :href="route('admin.marketplace.announcement.publish', $announcement)">
                                {{ __("Publish") }}
                            </x-a-buttons.primary>
                        @endif

                        @if ($announcement->status == App\Enums\Status::await_publication) 
                            <x-a-buttons.primary :href="route('admin.marketplace.announcement.stop_publication', $announcement)">
                                {{ __("Stop Publication") }}
                            </x-a-buttons.primary>
                        @endif
                        
                        <x-a-buttons.delete>
                            {{ __("Delete") }}
                        </x-a-buttons.delete>
                    </div>
                </div>
            </x-white-block>
        @endforeach
    </div>
    <div class="m-3">
        {{ $announcements->withQueryString()->links() }}
    </div>
</x-admin-layout>