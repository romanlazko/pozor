@props(['categories' => null, 'category' => null, 'data' => null])

<div class="w-full space-y-3">
    <x-search :category="$category" :search="$data['search'] ?? null"/>

    @if ($category)
        <x-breadcrumbs :category="$category"/>
    @endif
    
    <x-categories :categories="$categories" :category="$category"/>
</div>