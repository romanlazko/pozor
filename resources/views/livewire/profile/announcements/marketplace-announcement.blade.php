<div class="bg-white rounded-lg flex space-x-4 p-2">
    <div class="w-1/5">
        <img class="w-full aspect-square object-cover rounded-lg" src="{{ $announcement->photos()->first() ? asset('storage/'.$announcement->photos()->first()?->src) : '' }}" alt="">
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
                    <p class="text-xs md:text-sm text-gray-500">
                        {{ $announcement->price }} {{ $announcement->currency }} • {{ $announcement->created_at->diffForHumans() }}
                    </p>
                </div>
                <x-dropdown>
                    <x-slot name="trigger">
                        <x-a-buttons.secondary class="h-max" >
                            <i class="fa-solid fa-ellipsis"></i>
                        </x-a-buttons.secondary> 
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link>
                            {{ __("Edit") }}
                        </x-dropdown-link>
                        <x-dropdown-link wire:click="delete" wire:confirm="Are you sure you want to delete this announcement?">
                            {{ __("Delete") }}
                        </x-dropdown-link>
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
                        <form wire:submit="saveSold" class="p-2 space-y-2">
                            <p class="text-gray-600 text-sm">
                                Specify through which platform you sold the goods:
                            </p>
                            <x-form.label class="flex w-full items-center border border-gray-200 rounded-lg p-2 hover:border-gray-400 space-x-2">
                                <x-form.radio wire:model.live="sold" value="this-site"/>
                                <p>{{ __("I sold it on your site") }}</p>
                            </x-form.label>
                            <x-form.label class="flex w-full items-center border border-gray-200 rounded-lg p-2 hover:border-gray-400 space-x-2">
                                <x-form.radio wire:model.live="sold" value="another-place"/>
                                <p>{{ __("I sold it through another place") }}</p>
                            </x-form.label>
                            <x-form.label class="flex w-full items-center border border-gray-200 rounded-lg p-2 hover:border-gray-400 space-x-2">
                                <x-form.radio wire:model.live="sold" value="no-answer"/>
                                <p>{{ __("I don't want to answer") }}</p>
                            </x-form.label>
                            <x-buttons.primary @click="open = false" :disabled="!$sold">
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
                        <form wire:submit="discount" class="w-full p-3 space-y-3">
                            <x-form.input wire:model.live="new_price" class="w-full" placeholder="Set new price:" type="number"/>
                            <x-buttons.primary @click="open = false" :disabled="!$new_price">
                                {{ __("Save") }}
                            </x-buttons.primary>
                        </form>
                    </x-slot>
                </x-dropdown>
            @elseif($announcement->status == App\Enums\Status::sold)
                <x-a-buttons.secondary class="w-full md:w-max" wire:click="indicateAvailability">
                    {{ __("Indicate availability") }}
                </x-a-buttons.secondary>
            @endif
        </div>
    </div>
</div>
