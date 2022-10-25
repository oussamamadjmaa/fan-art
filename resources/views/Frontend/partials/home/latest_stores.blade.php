
@forelse ($latest_stores as $store)
@if ($loop->first) <div class="owl-carousel owl-theme py-3" id="storesSlider"> @endif
    <div>
        <a class="store-showcase_ text-center text-dark" href="{{ route('frontend.store.profile', $store->username) }}">
            <div class="store-showcase_-avatar mb-3 avatar-100 mx-auto text-center">
                <img src="{{ $store->avatar_url }}" alt="{{ $store->name }}" class="avatar-100">
            </div>
            <div class="store-showcase_-info">
                <h6 class="mb-0">{{ str($store->name)->limit(30) }}</h6>
                <small class="text-secondary">{{ __(country($store->country)->getName()) }}</small>
            </div>
        </a>
    </div>
@if ($loop->last) </div> @endif
@empty

@endforelse

