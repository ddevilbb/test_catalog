<nav>
    <div class="navbar-brand">
        <a href="{{ route('main') }}">Каталог</a>
    </div>
    <form class="form-inline" action="{{ route('search') }}" method="get">
        @csrf
        <input class="form-control form-control-sm" name="search" value="{{ $search ?? null }}" placeholder="Поиск товара"/>
        <button type="submit" class="btn btn-sm btn-primary">Найти</button>
    </form>
    <ul class="nav flex-column">
        @foreach($categories as $category)
            @include('components.nav-item', [
                'category' => $category
            ])
        @endforeach
    </ul>
</nav>