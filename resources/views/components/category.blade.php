<div class="ml-2" x-data="{ {{$category->slug}} : false}">
    <li x-on:click="{{$category->slug}} = ! {{$category->slug}}">
        {{ $category->name }}
    </li>
    <ul x-show="{{$category->slug}}">
        <x-categories :categories="$category->children"/>
    </ul>
</div>

