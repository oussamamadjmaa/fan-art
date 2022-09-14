<div class="product-card">
    <div class="product-image-container">
        <a class="product-image" href="{{ route('frontend.products.show', $product->id) }}">
            <img src="{{storage_url($product->image)}}" alt="{{$product->name}}">
        </a>
    </div>
    <div class="product-card-details">
        <a href="{{ route('frontend.products.show', $product->id) }}"><h5 class="product-name mb-0">{{$product->name}}</h5></a>
        <small class="text-secondary product-category mb-2">{{$product?->category?->name}}</small>
        <h5 class="product-price">{{$product->price_format}} <sup>@lang(config('app.currency'))</sup></h5>
    </div>
</div>
