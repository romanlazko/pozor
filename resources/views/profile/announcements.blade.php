<x-profile-layout>
    <div class="space-y-4 m-auto">
        @foreach ($announcements as $announcement)
            <div class="bg-white rounded-xl flex space-x-4 p-2 shadow-xl border-2 border-white hover:border-indigo-800">
                <div class="w-1/5">
                    <img class="w-full aspect-square object-cover rounded-lg" src="{{ $announcement->getFirstMediaUrl('announcements') }}" alt="">
                </div>
                <div class="w-4/5 flex flex-col space-y-4">
                    <div class="flex-1 md:space-y-2">
                        <div class="w-full flex space-x-2">
                            <div class="w-full overflow-hidden">
                                <p class="text-xs text-gray-500 underline w-min">
                                    {{ __($announcement->status->name) }} 
                                </p>
                                <h2 class="text-sm md:text-base font-semibold overflow-hidden w-full">
                                    {{ $announcement->title }}
                                </h2>
                                <p class="text-xs md:text-sm text-indigo-800">
                                    {{ $announcement->current_price }} {{ $announcement->currency->name }} • {{ $announcement->created_at->diffForHumans() }}
                                </p>
                                <p class="hidden md:block text-sm text-gray-800">
                                    {{ $announcement->description }}
                                </p>
                            </div>
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <button class="hover:text-gray-400 px-2">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button> 
                                </x-slot>
                                <x-slot name="content">
                                    <x-a-buttons.edit :href="route('announcement.edit', $announcement)" class="w-full">
                                        {{ __("Edit") }}
                                    </x-a-buttons.edit>
                                    <x-buttons.delete :action="route('announcement.delete', $announcement)" class="w-full">
                                        {{ __("Delete") }}
                                    </x-buttons.delete>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                    
                    <div class="md:flex items-center md:space-x-3 space-y-2 md:space-y-0">
                        @if ($announcement->status == App\Enums\Status::published)
                            <x-dropdown width="w-72">
                                <x-slot name="trigger">
                                    <x-a-buttons.primary class="w-full md:w-max">
                                        {{ __("Sold out") }}
                                    </x-a-buttons.primary>
                                </x-slot>
                                <x-slot name="content">
                                    <form action="{{ route('announcement.update', $announcement) }}" method="POST" class="p-2 space-y-2">
                                        @csrf
                                        @method('PATCH')
                                        <p class="text-gray-600 text-sm">
                                            Specify through which platform you sold the goods:
                                        </p>
                                        <x-form.label class="flex w-full items-center border border-gray-200 rounded-lg p-2 hover:border-gray-400 space-x-2">
                                            <x-form.radio name="sold" value="this-site"/>
                                            <p>{{ __("I sold it on this site") }}</p>
                                        </x-form.label>
                                        <x-form.label class="flex w-full items-center border border-gray-200 rounded-lg p-2 hover:border-gray-400 space-x-2">
                                            <x-form.radio name="sold" value="another-place"/>
                                            <p>{{ __("I sold it through another place") }}</p>
                                        </x-form.label>
                                        <x-form.label class="flex w-full items-center border border-gray-200 rounded-lg p-2 hover:border-gray-400 space-x-2">
                                            <x-form.radio name="sold" value="no-answer"/>
                                            <p>{{ __("I don't want to answer") }}</p>
                                        </x-form.label>
                                        <x-buttons.primary type="submit" name="sold">
                                            {{ __("Save") }}
                                        </x-buttons.primary>
                                    </form>
                                </x-slot>
                            </x-dropdown>
            
                            <x-dropdown width="w-72">
                                <x-slot name="trigger">
                                    <x-a-buttons.secondary class="w-full md:w-max">
                                        {{ __("Discount the price") }}
                                    </x-a-buttons.secondary>
                                </x-slot>
                                <x-slot name="content">
                                    <form action="{{ route('announcement.update', $announcement) }}" method="POST" class="w-full p-3 space-y-3">
                                        @csrf
                                        @method('PATCH')
                                        <x-form.input name="new_price" class="w-full" placeholder="Set new price:" type="number"/>
                                        <x-buttons.primary type="submit" name="discount">
                                            {{ __("Save") }}
                                        </x-buttons.primary>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        @elseif($announcement->status == App\Enums\Status::sold)
                            <form action="{{ route('announcement.update', $announcement) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <x-buttons.secondary class="w-full md:w-max" type="submit" name="indicate_availability">
                                    {{ __("Indicate availability") }}
                                </x-buttons.secondary>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="p-4">
        {{ $announcements->links() }}
    </div>
</x-profile-layout>