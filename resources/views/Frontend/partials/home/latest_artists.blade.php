
@forelse ($latest_artists as $artist)
        @if ($loop->first) <div class="owl-carousel owl-theme py-3" id="artistsSlider"> @endif
            <div>
                <a class="artist-showcase_ text-center text-dark" href="{{ route('frontend.artist.profile', $artist->username) }}">
                    <div class="artist-showcase_-avatar mb-3 avatar-150 mx-auto text-center">
                        <img src="{{ $artist->avatar_url }}" alt="{{ $artist->name }}" class="avatar-150">
                    </div>
                    <div class="artist-showcase_-info">
                        <h5>{{ str($artist->name)->limit(30) }}</h5>
                        <h6>{{ __(country($artist->country)->getName()) }}</h6>
                    </div>
                </a>
            </div>
        @if ($loop->last) </div> @endif
@empty

@endforelse

