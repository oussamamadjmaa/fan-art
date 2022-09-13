@if ($artwork instanceof \App\Models\Artwork)
<div class="artwork-showcase_ text-center text-dark">
    <div class="artwork-showcase_-image mb-3 mx-auto text-center">
        <a class="img_" href="{{route('frontend.artworks.show', $artwork->slug)}}">
            <img src="{{ storage_url($artwork->image) }}" alt="{{ $artwork->title }}">
        </a>

    </div>
    <div class="artwork-showcase_-info">
        <a href="{{route('frontend.artworks.show', $artwork->slug)}}" class="text-dark">
            <h5 class="mb-0">{{ str($artwork->title)->limit(30) }}</h5>
            <div class="text-secondary">
                <small>{{ $artwork->dimensions }}</small>
                <br>
                <small>{{ $artwork->location }}</small>
            </div>
            <h6>{{ $artwork->price_format }} {{ __(config('app.currency')) }}</h6>
        </a>
    </div>
</div>
@endif
