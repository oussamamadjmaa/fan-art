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

            <div class="artists-list">
                @forelse ($artists as $artist)
                <div class="artists-list-item mb-5">
                    <div class="row">
                        <div class="col-md-3 mb-3 mb-md-0">
                            <div class="artist-information">
                                <div>
                                    <a class="artist-showcase_ text-dark" href="{{ route('frontend.artist.profile', $artist->username) }}">
                                        <div class="artist-showcase_-avatar mb-3 avatar-150 mx-auto">
                                            <img src="{{ $artist->avatar_url }}" alt="{{ $artist->name }}" class="avatar-150">
                                        </div>
                                        <div class="artist-showcase_-info text-center">
                                            <h5>{{ str($artist->name)->limit(30) }}</h5>
                                            <h6>{{ __(country($artist->country)->getName()) }}</h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @forelse ($artist->artworks()->latest()->limit(3)->get() as $artwork)
                            <div class="col-md-3 col-sm-6 @if(!$loop->first) d-none d-sm-block @endif">
                                <div>
                                    @include('Frontend.partials.artwork.single')
                                </div>
                            </div>
                        @empty
                            <div class="col">
                                <div class="text-center h-100 d-flex align-items-center justify-content-center">
                                    <h6>@lang("This artist didn't post any artwork yet")</h6>
                                </div>
                            </div>
                        @endforelse
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
