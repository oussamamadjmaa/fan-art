@forelse ($products ?? [] as $product)
    @include('Backend.Product.partials.signle')
@empty
<div class="p-3 no-data">
    @lang('No Data')
</div>
@endforelse
