<div {{ $attributes->merge(['class' => 'bg-white shadow rounded-lg w-full overflow-auto ' . ($attributes->get('class') ?? 'p-4')]) }}>
    {{ $slot }}
</div>