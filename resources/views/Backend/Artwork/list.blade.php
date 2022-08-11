@forelse ($artworks ?? [] as $artwork)
    @include('Backend.Artwork.partials.signle')
@empty
<div class="p-3 no-data">
    @lang('No Data')
</div>
@endforelse
