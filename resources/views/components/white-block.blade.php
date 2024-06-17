<div {{ $attributes->merge(['class' => 'bg-white rounded-lg w-full overflow-auto border ' . ($attributes->get('class') ?? 'p-4')]) }}>
    {{ $slot }}
</div>