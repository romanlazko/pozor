@props(['cols' => 1, 'layout' => 'sm', 'announcements' => [], 'paginator' => null])

<div 
    @class(['w-full gap-3 lg:gap-y-12 grid grid-cols-2', 'lg:grid-cols-1' => $cols == 1, 'lg:grid-cols-2' => $cols == 2, 'lg:grid-cols-3' => $cols == 3, 'lg:grid-cols-4' => $cols == 4, 'lg:grid-cols-5' => $cols == 5])
>
    @foreach ($announcements as $index => $announcement)
        <x-announcement-card :announcement="$announcement" :layout="$layout" @class(['rounded-lg'])/>
    @endforeach
</div>
<div class="p-4">
    {{ $paginator?->onEachSide(1)->links() }}
</div>