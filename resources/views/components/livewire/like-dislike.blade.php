<button wire:click="like()" onclick="event.preventDefault()" @class(['fa-solid fa-heart text-gray-400 hover:text-red-400', 'text-red-600' => $lastUserVote === 1])>
    <x-heroicon-s-heart class="size-5"/>
</button>