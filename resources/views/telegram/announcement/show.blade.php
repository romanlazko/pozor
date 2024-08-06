<b>#{{ ($announcement->getFeatureByName('real_estate_type') ?? $announcement->getFeatureByName('type'))?->value }}</b>

<b>{{ $announcement->getFeatureByName('title')?->value }}</b>

<a href="{{ route('announcement.show', $announcement) }}">Посмотреть объявление</a>

@foreach ($announcement->categories as $category)
    <b>#{{ $category->name }}</b>
@endforeach

