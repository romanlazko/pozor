@props(['layout' => 'sm', 'announcements' => []])

<div 
    @class(['w-full gap-3 grid', 'grid-cols-2' => $layout == 'sm', 'grid-cols-3' => $layout == 'md', 'grid-cols-4' => $layout == 'lg', 'grid-cols-6' => $layout == 'xl'])
>
    @foreach ($announcements as $index => $announcement)
        <x-announcement-card :announcement="$announcement" :layout="$layout" @class(['rounded-lg'])/>
    @endforeach
</div>