@extends('Frontend.Layout.app')
@section('content')
    <section class="artist-profile-header bg-white">
        <div class="container py-md-5 py-3 border-bottom">
            <div class="d-flex overflow-hidden">
                <div class="me-md-5 me-3">
                    <div class="avatar">
                        <img src="{{ $artist->avatar_url }}" alt="" class="avatar">
                    </div>
                </div>
                <div class="artist-profile-info flex-grow-1">
                    <div class="d-md-flex flex-wrap py-2" style="gap: 1.6rem;">
                        <div>
                            <h5 class="artist-name">{{ $artist->name }}</h5>
                            <h6>{{ __(country($artist->country)->getName()) }}, {{ __($artist->nationality) }}</h6>
                        </div>
                    </div>
                    <div class="d-ph-none">
                        <p>{{ $artist->profile->bio }}</p>
                    </div>
                </div>
            </div>
            <div class="d-pc-none mt-3">
                <p>{{ $artist->profile->bio }}</p>
            </div>
        </div>
    </section>

    <section class="artist-profile-tabs bg-white">
        <div class="container tabs__">
            <ul class="list-unstyled d-flex">
                <li @class(['active' => $profile_page == "artworks"])><a href="{{ route('frontend.artist.profile',$artist->username) }}"> <i class="bi bi-palette"></i> @lang('Artworks')</a></li>
                <li @class(['active' => $profile_page == "blogs"])><a href="{{ route('frontend.artist.profile',[$artist->username, 'blogs']) }}"> <i class="bi bi-quote"></i> @lang('Blog')</a></li>
            </ul>
        </div>
    </section>

    {{-- Artist Artworks --}}
    @if ($profile_page == "artworks")
    <section class="artist_artworks bg-white">
        <div class="container">
            @include('Frontend.Artist.partials.artworks')
            @if (!empty(trim($artist_artworks->links())))
                <div class="text-center d-flex justify-content-center py-4">
                    {{$artist_artworks->withQueryString()->onEachSide(0)->links()}}
                </div>
            @endif
        </div>
    </section>
    @elseif ($profile_page == "blogs")
    <section class="artist_blogs bg-white">
        <div class="container">
            @include('Frontend.Artist.partials.blogs')
            @if (!empty(trim($artist_blogs->links())))
                <div class="text-center d-flex justify-content-center py-4">
                    {{$artist_blogs->withQueryString()->onEachSide(0)->links()}}
                </div>
            @endif
        </div>
    </section>
    @endif
@endsection
