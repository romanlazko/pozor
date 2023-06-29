<x-guest-layout>
    <x-slot name="header">
        
        <div class="flex items-center space-x-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Baraholka') }}
            </h2>
            <div>
                <form action="{{ route('baraholka') }}" class="form">
                    <x-telegram::form.select name="type">
                        <option value="">Type</option>
                        @foreach (App\Bots\pozor_baraholka_bot\Models\BaraholkaAnnouncement::distinct()->pluck('type') as $type)
                            <option value="{{ $type }}" @selected(old('type', request()->type) == $type)>{{ $type }}</option>
                        @endforeach
                    </x-telegram::form.select>
                    <x-telegram::form.select name="category">
                        <option value="">Category</option>
                        @foreach (App\Bots\pozor_baraholka_bot\Models\BaraholkaAnnouncement::distinct()->pluck('category') as $category)
                            <option value="{{ $category }}" @selected(old('category', request()->category) == $category)>{{ $category }}</option>
                        @endforeach
                    </x-telegram::form.select>
                    <x-telegram::form.select name="city">
                        <option value="">City</option>
                        @foreach (App\Bots\pozor_baraholka_bot\Models\BaraholkaAnnouncement::distinct()->pluck('city') as $city)
                            <option value="{{ $city }}" @selected(old('city', request()->city) == $city)>{{ $city }}</option>
                        @endforeach
                    </x-telegram::form.select>
                    <x-telegram::buttons.primary>
                        {{ __('Search') }}
                    </x-telegram::buttons.primary>
                </form>
            </div>
            
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid sm:grid-cols-3 grid-cols-1">
                @foreach ($announcements_collection as $announcement)
                    <div class="p-4 announcement ">
                        <div class="bg-white rounded-lg shadow-lg">
                            <img src="{{ $announcement->photos->first()?->url }}" alt="Product Image" class="w-full h-[300px] object-center object-cover rounded-t-lg main-img">
                        </div>
                        <div class="flex items-center justify-center">
                            @forelse ($announcement->photos as $photo)
                                <img src="{{$photo?->url}}" alt="Additional Image 1" class="w-12 h-12 p-1 rounded-md" onmouseover="$(this).closest('.announcement').find('.main-img').attr('src', '{{$photo?->url}}');">
                            @empty
                                
                            @endforelse
                        </div>
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold">{{ $announcement->title }}</h3>
                            <p class="text-gray-500">{{ $announcement->caption }}</p>
                            <p class="text-green-500 font-bold mt-2">{{ $announcement->cost }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mx-3">
                {{ $announcements->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-guest-layout>