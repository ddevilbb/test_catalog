@if(isset($activeCategory))
    <h1>{{ $activeCategory->getTitle() }}</h1>
@endif
<div class="card-columns">
    @forelse($products as $product)
        <div class="card">
            <img class="card-img-top" src="{{ $product->getImage() }}" align="center">
            <div class="card-body">
                <h5 class="card-title">
                    <a href="{{ route('show_product', [
                'alias' => isset($activeCategory) ? $activeCategory->getAlias() : $product->getCategories()->first()->getAlias(),
                'id' => $product->getId()
            ]) }}">
                        {{ $product->getTitle() }}
                    </a>
                </h5>
                <p class="card-text">Цена: {{ number_format($product->getPrice(), 2) }} &#8381;</p>
                <p class="card-text">Кол-во: {{ $product->getAmount() }}</p>
                <p class="card-text">{{ str_limit($product->getDescription(), 100) }}</p>
            </div>
        </div>
    @empty
        <div class="col-12">
            <p>Товары не найдены!</p>
        </div>
    @endforelse
</div>