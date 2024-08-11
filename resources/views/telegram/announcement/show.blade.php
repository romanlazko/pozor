<b>{{ 
    $announcement->getSectionByName('type')
        ?->pluck('value')
        ?->map(fn ($value) => str()
            ->of($value)
            ->lower()
            ->replace(' ', '_')
            ->prepend('#')
        )
        ?->implode(' ')
}}</b>

<b>{{ 
    $announcement->getSectionByName('title')
        ->pluck('value')
        ->implode(' ')
}}</b>

Стоимость: {{ 
    $announcement->getSectionByName('price')
        ->pluck('value')
        ->implode(' ')
}}

<b>{{ 
    $announcement->categories
        ->pluck('name')
        ->map(fn ($value) => str()
            ->of($value)
            ->lower()
            ->replace(' ', '_')
            ->prepend('#')
        )
        ->implode(' ')
}}</b>