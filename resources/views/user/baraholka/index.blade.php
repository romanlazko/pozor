<x-guest-layout>
    <x-slot name="header">
        
        {{-- <div class="flex items-center space-x-3 w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight w-full">
                {{ __('Baraholka') }}
            </h2>
        </div> --}}
        <div class="w-full">
            <form action="{{ route('baraholka') }}" class="grid sm:grid-cols-5 grid-cols-1 form space-y-2 items-center sm:space-x-3">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Baraholka') }}
                </h2>
                <x-telegram::form.select name="type">
                    <option value="">Type</option>
                    @foreach (App\Bots\pozor_baraholka_bot\Models\BaraholkaAnnouncement::distinct('type')->pluck('type') as $type)
                        <option value="{{ $type }}" @selected(old('type', request()->type) == $type)>{{ ucfirst($type) }}</option>
                    @endforeach
                </x-telegram::form.select>
                <x-telegram::form.select name="category">
                    <option value="">Category</option>
                    @foreach (App\Bots\pozor_baraholka_bot\Models\BaraholkaAnnouncement::distinct('category')->pluck('category') as $category)
                        <option value="{{ $category }}" @selected(old('category', request()->category) == $category)>{{ ucfirst($category) }}</option>
                    @endforeach
                </x-telegram::form.select>
                <x-telegram::form.select name="city">
                    <option value="">City</option>
                    @foreach (App\Bots\pozor_baraholka_bot\Models\BaraholkaAnnouncement::distinct('city')->pluck('city') as $city)
                        <option value="{{ $city }}" @selected(old('city', request()->city) == $city)>{{ ucfirst($city) }}</option>
                    @endforeach
                </x-telegram::form.select>
                <x-telegram::buttons.primary>
                    {{ __('Search') }}
                </x-telegram::buttons.primary>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid sm:grid-cols-3 grid-cols-1">
                @foreach ($announcements_collection as $announcement)
                    <div class="p-4 announcement ">
                        <div class="bg-white rounded-lg shadow-lg">
                            <img src="data:image/jpeg;base64,{{ base64_encode($announcement->photos->first()?->url) }}" alt="Product Image" class="w-full h-[300px] object-center object-cover rounded-t-lg main-img">
                        </div>
                        <div class="flex items-center justify-center">
                            @forelse ($announcement->photos->take(9) as $photo)
                                <img src="data:image/jpeg;base64,{{ base64_encode($photo?->url) }}" alt="Additional Image 1" class="w-12 h-12 p-1 rounded-md" onmouseover="$(this).closest('.announcement').find('.main-img').attr('src', 'data:image/jpeg;base64,{{ base64_encode($photo?->url) }}');">
                            @empty
                                
                            @endforelse
                        </div>
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold">{{ $announcement->title }}</h3>
                            <p class="text-gray-500">{!! nl2br(e($announcement->caption)) !!}</p>
                            
                            <p class="text-green-500 font-bold mt-2">{{ $announcement->cost ? $announcement->cost ." CZK" : "" }} </p>
                            <x-telegram::a-buttons.primary class="w-full" href="https://t.me/pozor_baraholka_bot?start=announcement={{$announcement->id}}">
                                {{ __('Contact') }}
                            </x-telegram::a-buttons.primary>
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