<div class="owl-carousel owl-theme painting-border" id="heroSlider">
    @forelse ($carousels as $i => $carousel)
        <div class="hero-carousel-item {{ $carousel->cover ? 'carousel-cover' : '' }}">
            <img src="{{ storage_url($carousel->background_image) }}" alt="{{ $carousel->name }}">
            <div class="carousel-content">
                <h1>{{ $carousel->text }}</h1>
                <h3>{{ $carousel->secondary_text }}</h3>
                @if ($carousel->action == 'button_link')
                    <a href="{{ $carousel->action_data['url'] }}" class="carousel-link-btn"
                        style="background-color:{{ $carousel->action_data['color'] }};">
                        {{ $carousel->action_data['text'] }}
                    </a>
                @elseif ($carousel->action == 'countdown')
                    <div class="countdown-timer countdown_p" data-date="{{ $carousel->action_data['countdown_date'] }}">
                        <div class="countdown_ d-flex">
                            <div class="countdown_item">
                                <h1 class="number days">00</h1>
                                <h6 class="text">@lang('Days')</h6>
                            </div>
                            <h1 class="seperator">:</h1>
                            <div class="countdown_item">
                                <h1 class="number hours">00</h1>
                                <h6 class="text">@lang('Hours')</h6>
                            </div>
                            <h1 class="seperator">:</h1>
                            <div class="countdown_item">
                                <h1 class="number minutes">00</h1>
                                <h6 class="text">@lang('Mintues')</h6>
                            </div>
                            <h1 class="seperator">:</h1>
                            <div class="countdown_item">
                                <h1 class="number seconds">00</h1>
                                <h6 class="text">@lang('Seconds')</h6>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @empty
    <div class="hero-carousel-item carousel-cover">
        <img src="{{asset('assets/images/bgs/carousel-1.webp')}}">
        <div class="carousel-content">
            <h1>موقع فــن أرت</h1>
            <h3>مرحبا بك في موقع فــن أرت الجديد</h3>
            <a href="{{ route('login') }}" class="carousel-link-btn">
                تسجيل الدخول
            </a>
        </div>
    </div>
    @endforelse
</div>
