@extends('Frontend.Layout.app')
@section('content')
    {{-- Carousels --}}
    <home-hero-slider :sliders="{{ json_encode($carousels) }}"></home-hero-slider>


    {{-- Who's us --}}
    <section class="whos_us bg-white painting-border pt-4 pb-2">
        <div class="container pb-3 pt-5">
            <div class="row align-items-center">
                <div class="col-md-6 text-center">
                    <div class="col-md-10">
                        <h1 class="mb-3 fs-2 fw-bold">من نحن</h1>
                        <p style="font-size:17px;font-weight:200;">{{config('app.whos_us.text')}}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="youtube-iframe">{!! config('app.whos_us.video') !!}</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Latest Artists --}}
    <joined-us></joined-us>

    {{-- Latest Artworks --}}
    @if ($latest_artworks->count())
    <section class="latest_artworks bg-white painting-border pt-4 pb-2">
        <div class="container  pb-1 pt-3">
             <h1 class="mb-3 fs-3"><a href="{{route('frontend.artworks.index')}}">@lang('Latest paintings and artworks'):</a></h1>
             @include('Frontend.partials.home.latest_artworks')
        </div>
     </section>
    @endif

    <section id="homeAd_1" class="bg-white border-top border-bottom">
        <div class="container py-5 d-flex justify-content-center" style="overflow: hidden;max-width:100%;">
            <div id="banner-ad" class="text-center" style="max-width:100%;width:100%;">
                {!!config('app.ads.home_banner_ad')!!}
            </div>
        </div>
    </section>

    {{-- Latest Blogs from artists --}}
    @if ($artists_with_last_blog->count() && Route::has('frontend.blogs.index'))
    <section class="blogs-page bg-white pt-2 pb-2">
        <div class="container pb-1 pt-3">
            <h1 class="mb-3 fs-3"><a href="{{route('frontend.artworks.index')}}">@lang('Artist blog'):</a></h1>
            @include('Frontend.Blogs.partials.list')
        </div>
    </section>
    @endif

    {{-- Latest Stores --}}
    @if ($latest_stores->count())
    <section class="latest_stores bg-white border-top pt-2 pb-2">
        <div class="container pb-1 pt-3">
             <h1 class="mb-2 fs-3"><a href="javascript:;">@lang('Stores'):</a></h1>
             @include('Frontend.partials.home.latest_stores')
        </div>
     </section>
    @endif


@endsection
@push('scripts')
    @vite(['resources/frontend-assets/js/pages/home.js'])
@endpush
