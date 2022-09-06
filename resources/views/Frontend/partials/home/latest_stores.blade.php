
@forelse ($latest_stores as $store)
@if ($loop->first) <div class="owl-carousel owl-theme py-3" id="storesSlider"> @endif
    <div>
        <a class="store-showcase_ text-center text-dark" href="javascript:;">
            <div class="store-showcase_-avatar mb-3 avatar-150 mx-auto text-center">
                <img src="{{ $store->avatar_url }}" alt="{{ $store->name }}" class="avatar-150">
            </div>
        </a>
    </div>
@if ($loop->last) </div> @endif
@empty

@endforelse

