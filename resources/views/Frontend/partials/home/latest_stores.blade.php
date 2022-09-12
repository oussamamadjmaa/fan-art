
@forelse ($latest_stores as $store)
@if ($loop->first) <div class="owl-carousel owl-theme py-3" id="storesSlider"> @endif
    <div>
        <a class="store-showcase_ text-center text-dark" href="{{ route('frontend.store.profile', $store->username) }}">
            <div class="store-showcase_-avatar mb-3 avatar-150 mx-auto text-center">
                <img src="{{ $store->avatar_url }}" alt="{{ $store->name }}" class="avatar-150">
            </div>
            <div class="store-showcase_-info">
                <h5>{{ str($store->name)->limit(30) }}</h5>
                <h6>{{ __(country($store->country)->getName()) }}</h6>
            </div>
        </a>
    </div>
@if ($loop->last) </div> @endif
@empty

@endforelse

