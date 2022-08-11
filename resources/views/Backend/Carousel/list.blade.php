@forelse ($carousels ?? [] as $carousel)
    @include('Backend.Carousel.partials.signle')
@empty
<div class="p-3 no-data">
    @lang('No Data')
</div>
@endforelse
