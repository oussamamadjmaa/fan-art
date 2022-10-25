@extends('Frontend.Layout.app')
@section('content')
    {{-- Artworks --}}
    <section class="artists-page bg-white py-5">
        <div class="container">
            <h1 class="mb-2">@lang('Artists')</h1>
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('frontend.home')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:;">@lang('Artists')</a></li>
                </ol>
            </nav>

            <div>
                <div class="d-flex flex-wrap justify-content-end">
                    <div class="dropdown open mb-4">
                        <a class="bg-light d-block text-dark p-2 pb-1" href="javascript:;" type="button" id="artistType" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                   <i class="bi bi-filter"></i> @lang('Artist type'): @lang($getByArtistTypeList[$currentArtistType] ?? 'all')
                                </a>
                        <div class="dropdown-menu" aria-labelledby="artistType">
                            @foreach ($getByArtistTypeList as $artistTypeKey => $artistTypeTxt)
                                <a class="dropdown-item" href="{{request()->fullUrlWithQuery(['artist_type' => $artistTypeKey])}}">@lang($artistTypeTxt)</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="artists-list row">
                @forelse ($artists as $artist)
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="artists-list-item mb-5">
                        <div class="artist-information">
                            <div>
                                <a class="artist-showcase_ text-dark" href="{{ route('frontend.artist.profile', $artist->username) }}">
                                    <div class="artist-showcase_-avatar mb-3 avatar-120 mx-auto">
                                        <img src="{{ $artist->avatar_url }}" alt="{{ $artist->name }}" class="avatar-120">
                                    </div>
                                    <div class="artist-showcase_-info text-center">
                                        <h6 class="mb-0">{{ str($artist->name)->limit(30) }}</h6>
                                        <small class="text-secondary">{{ __(country($artist->country)->getName()) }} (@lang($artist->artist_type))</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <h1 style="font-size: 90px;"><i class="bi bi-palette"></i></h1>
                    <p>@lang("There's no artists yet").</p>
                </div>
                @endforelse
            </div>
            @if (!empty(trim($artists->links())))
                <div class="text-center d-flex justify-content-center py-4">
                    {{$artists->withQueryString()->onEachSide(0)->links()}}
                </div>
            @endif
        </div>
    </section>
@endsection
