<a wire:click="like()" class="cursor-pointer">
    <i @class(['fa-solid fa-heart text-gray-400 hover:text-red-400', 'text-red-600' => $lastUserVote === 1])></i>
</a>