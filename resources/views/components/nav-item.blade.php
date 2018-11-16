@if(!$category->getChildren()->isEmpty())
    <li class="nav-item dropdown">
        <a href="{{ route('show_category', ['alias' => $category->getAlias()]) }}"
           class="nav-link dropdown-toggle" role="button" data-toggle="dropdown">
            {{ $category->getTitle() }}
        </a>
        <ul class="dropdown-menu">
        @foreach($category->getChildren() as $child)
            @include('components.nav-item', [
                'category' => $child
            ])
        @endforeach
        </ul>
    </li>
@else
    <li class="nav-item">
        <a href="{{ route('show_category', ['alias' => $category->getAlias()]) }}" class="nav-link">
            {{ $category->getTitle() }}
        </a>
    </li>
@endif
