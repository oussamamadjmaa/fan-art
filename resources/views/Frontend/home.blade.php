@extends('Frontend.Layout.app')
@section('content')
    {{-- Carousels --}}
    @include('Frontend.partials.home.carousel')

    {{-- Latest Artists --}}
    @if ($latest_artists->count())
    <section class="latest_artists bg-white painting-border py-4">
        <div class="container py-5">
             <h1 class="mb-5">@lang('Joined us') :</h1>
             @include('Frontend.partials.home.latest_artists')

             <div class="text-md-end text-center mt-4">
                 <a href="#" class="primary-btn">@lang('Show all artists')</a>
             </div>
        </div>
     </section>
    @endif

    {{-- Latest Artworks --}}
    @if ($latest_artworks->count())
    <section class="latest_artworks bg-white pt-4">
        <div class="container py-5">
             <h1 class="mb-5">@lang('Latest paintings and artworks') :</h1>
             @include('Frontend.partials.home.latest_artworks')

             <div class="text-md-end text-center mt-4">
                 <a href="{{route('frontend.artworks.index')}}" class="primary-btn">@lang('Show all artworks')</a>
             </div>
        </div>
     </section>
    @endif

    <section id="homeAd_1" class="bg-white border-top border-bottom">
        <div class="container py-4 d-flex justify-content-center" style="overflow: hidden;max-width:100%;">
            <div id="banner-ad" class="text-center" style="max-width:100%;width:100%;"></div>
        </div>
    </section>

@endsection
@push('scripts')
    @vite(['resources/frontend-assets/js/pages/home.js'])
@endpush
