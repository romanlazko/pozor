<div class="w-full space-y-6">
    <x-user-card :user="$user"/>
    

    <div class="w-full space-y-4">
        @if ($user?->phone)
            <label class="text-gray-500 flex text-sm items-center space-x-1">
                <i class="fa-solid fa-phone"></i>
                <span>
                    {{ __("Phone:") }}
                </span>
                <a href="tel:{{ $user?->phone }}" class="inline-block w-full h-full text-blue-600 hover:underline cursor-pointer">{{ $user?->phone }}</a>
            </label>
        @endif
    
        @if ($user?->email)
            <label class="text-gray-500 flex text-sm items-center space-x-1">
                <i class="fa-solid fa-at"></i>
                <span>
                    {{ __("Email:") }}
                </span>
                <a href="mailto:{{ $user?->email }}" class="inline-block w-full h-full text-blue-600 hover:underline cursor-pointer">{{ $user?->email }}</a>
            </label>
        @endif
    
        @if ($user?->chat?->username)
            <label class="text-gray-500 flex text-sm items-center space-x-1">
                <i class="fa-brands fa-telegram"></i>
                <span>
                    {{ __("Telegram:") }}
                </span>
                <a href="https://t.me/{{ $user?->chat?->username }}" class="inline-block w-full h-full text-blue-600 hover:underline cursor-pointer">{{ $user?->chat?->username }}</a>
            </label>
        @endif
    </div>
</div>
    

