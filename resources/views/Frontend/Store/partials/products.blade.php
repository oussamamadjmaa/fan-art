@forelse ($store_products as $product)
    @if ($loop->first)
        <div class="row">
    @endif
    <div class="col-lg-3 col-md-4">
        @include('Frontend.Products.partials.single')
    </div>
    @if ($loop->last)
        </div>
    @endif
@empty
<div class="text-center py-5">
    <h1 style="font-size: 90px;"><i class="bi bi-shop"></i></h1>
    @if ($store->id == auth()->id())
        <p>@lang("You don't have any products yet").</p>
        <a href="{{ route('backend.products.index') }}">@lang('Add Product')</a>
    @else
        <p>@lang("This store doesn't have any products yet").</p>
    @endif
</div>
@endforelse
