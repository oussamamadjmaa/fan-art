@forelse ($artist_artworks as $artwork)
    @if ($loop->first)
        <div class="artworks-grid">
    @endif
    <div class="artwork-grid-item mb-md-3 mb-2">
        @include('Frontend.partials.artwork.single')
    </div>
    @if ($loop->last)
        </div>
    @endif
@empty
    <div class="text-center py-5">
        <h1><i class="bi bi-palette"></i></h1>
        @if ($artist->id == auth()->id())
            <p>@lang("You didn't post any artwork yet").</p>
            <a href="{{ route('backend.artworks.index') }}">@lang('Add Artwork')</a>
        @else
            <p>@lang("This artist didn't post any artwork yet").</p>
        @endif
    </div>
@endforelse
