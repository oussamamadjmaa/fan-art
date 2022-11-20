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
                            <h5 class="artist-name">{{ $artist->name }} </h5>
                            <h6>{{ __(country($artist->country)->getName()) }}, {{ __($artist->nationality) }}</h6>
                            <h6 class="mt-3 text-primary">@lang($artist->artist_type)</h6>
                        </div>
                    </div>
                    <div class="d-ph-none">
                        <p>{{ $artist?->profile?->bio }}</p>
                    </div>
                    {{-- <div>
                        <ul class="artist-contact-info list-unstyled">
                            @if ($artist->website)
                            <li>
                                <a class="text-dark" title="@lang('Website')" target="_blank" href="{{$artist->website}}"><i class="fa fa-link"></i> <span dir="ltr">{{str_replace(['http://', 'https://'], '',$artist->website)}}</span></a>
                            </li>
                            @endif
                            @if ($artist->email && $artist->profile?->privacy_settings?->show_email)
                            <li>
                                <a class="text-dark" title="@lang('Email')" href="mailto:{{$artist->email}}"><i class="fa fa-envelope"></i> {{$artist->email}}</a>
                            </li>
                            @endif
                            @if ($artist->phone && $artist->profile?->privacy_settings?->show_phone)
                            <li>
                                <a class="text-dark" title="@lang('Phone')" href="tel:{{$artist->phone}}"><i class="fa fa-phone"></i>  <span dir="ltr">{{$artist->phone}}</span></a>
                            </li>
                            @endif
                        </ul>
                        <ul class="artist-social-media-links d-flex flex-wrap list-unstyled">
                            @if (!empty($artist->profile?->social_media['whatsapp']))
                            <li>
                                <a title="@lang('Whatsapp')" href="https://wa.me/{{$artist->profile->social_media['whatsapp']}}" target="_blank"><i class="fab fa-whatsapp"></i></a>
                            </li>
                            @endif
                            @if (!empty($artist->profile?->social_media['facebook']))
                            <li>
                                <a title="@lang('Facebook')" href="{{$artist->profile->social_media['facebook']}}" target="_blank"><i class="fab fa-facebook"></i></a>
                            </li>
                            @endif
                            @if (!empty($artist->profile?->social_media['instagram']))
                            <li>
                                <a title="@lang('Instagram')" href="{{$artist->profile->social_media['instagram']}}" target="_blank"><i class="fab fa-instagram"></i></a>
                            </li>
                            @endif
                            @if (!empty($artist->profile?->social_media['twitter']))
                            <li>
                                <a title="@lang('Twitter')" href="{{$artist->profile->social_media['twitter']}}" target="_blank"><i class="fab fa-twitter"></i></a>
                            </li>
                            @endif
                            @if (!empty($artist->profile?->social_media['linkedin']))
                            <li>
                                <a  title="@lang('Linkedin')"href="{{$artist->profile->social_media['linkedin']}}" target="_blank"><i class="fab fa-linkedin"></i></a>
                            </li>
                            @endif
                        </ul>
                    </div> --}}
                </div>
            </div>
            <div class="d-pc-none mt-3">
                <p>{{ $artist->profile?->bio }}</p>
            </div>
        </div>
    </section>

    <section class="artist-profile-tabs bg-white">
        <div class="container tabs__">
            <ul class="list-unstyled d-flex">
                <li @class(['active' => $profile_page == "artworks"])><a href="{{ route('frontend.artist.profile',$artist->username) }}"> <i class="bi bi-palette"></i> @lang('Artworks')</a></li>
                @if (Route::has('frontend.blogs.index'))
                <li @class(['active' => $profile_page == "blogs"])><a href="{{ route('frontend.artist.profile',[$artist->username, 'blogs']) }}"> <i class="bi bi-quote"></i> @lang('Blog')</a></li>
                @endif
            </ul>
        </div>
    </section>

    {{-- Artist Artworks --}}
    @if ($profile_page == "artworks")
    <section class="artist_artworks bg-white">
        <div class="container">
            @if ($artist_artworks->count())
            <div>
                <div class="d-flex flex-wrap justify-content-end">
                    <div class="dropdown open mb-4">
                        <a class="bg-light d-block text-dark p-2 pb-1" href="javascript:;" type="button" id="sortBy" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                   <i class="bi bi-filter"></i> @lang('Sort by'): @lang($sortByList[$currentSortBy] ?? 'Latest')
                                </a>
                        <div class="dropdown-menu" aria-labelledby="sortBy">
                            @foreach ($sortByList as $sortByKey => $sortByText)
                                <a class="dropdown-item" href="{{request()->fullUrlWithQuery(['sortBy' => $sortByKey])}}">@lang($sortByText)</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
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
            @if ($artist_blogs->count())
            <div>
                <div class="d-flex flex-wrap justify-content-end">
                    <div class="dropdown open mb-4">
                        <a class="bg-light d-block text-dark p-2 pb-1" href="javascript:;" type="button" id="sortBy" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                   <i class="bi bi-filter"></i> @lang('Sort by'): @lang($sortByList[$currentSortBy] ?? 'Latest')
                                </a>
                        <div class="dropdown-menu" aria-labelledby="sortBy">
                            @foreach ($sortByList as $sortByKey => $sortByText)
                                <a class="dropdown-item" href="{{request()->fullUrlWithQuery(['sortBy' => $sortByKey])}}">@lang($sortByText)</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
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
