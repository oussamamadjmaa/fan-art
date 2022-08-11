
@forelse ($latest_artworks as $artwork)
@if ($loop->first) <div class="artworks-grid"> @endif
    <div class="artwork-grid-item">
        @include('Frontend.partials.artwork.single')
    </div>
@if ($loop->last) </div> @endif
@empty

@endforelse

