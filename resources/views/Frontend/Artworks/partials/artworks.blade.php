@forelse ($artworks as $artwork)
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
        <h1 style="font-size: 90px;"><i class="bi bi-palette"></i></h1>
        <p>@lang("There's no artworks yet").</p>
    </div>
@endforelse
