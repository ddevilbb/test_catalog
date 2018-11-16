<div class="row">
    <div class="col-12 col-sm-6 col-md-4">
        <img class="card-img" src="{{ $product->getImage() }}"/>
    </div>
    <div class="col-12 col-sm-6 col-md-8">
        <h5 class="card-title">{{ $product->getTitle() }}</h5>
        <p class="card-text">Цена: {{ number_format($product->getPrice(), 2) }} &#8381;</p>
        <p class="card-text">{{ $product->getDescription() }}</p>
        @if (!$product->getOffers()->isEmpty())
            <h6>Предложения</h6>
            @foreach($product->getOffers() as $offer)
                <p class="card-text">
                    {{ $offer->getArticle() }} |
                    {{ number_format($offer->getPrice()) }} &#8381; |
                    на складе {{ $offer->getAmount() }} шт. |
                    продано {{ $offer->getSales() }} шт.
                </p>
            @endforeach
        @endif
    </div>
</div>