@extends('Frontend.Layout.app')
@section('content')
    {{-- Artworks --}}
    <section class="artworks bg-white py-4">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('frontend.home')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{route('frontend.artworks.index')}}">@lang('Paintings and artwork')</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:;">{{$artwork->title}}</a></li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-md-6">
                    <div class="artwork-page-image px-md-3 mb-md-0 mb-3">
                        <img src="{{storage_url($artwork->image)}}" alt="{{ $artwork->title }} - {{ $artwork->user->name }}" style="width:100%;height:100%;object-fit:contain;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <h1 class="fs-3 mb-0">{{ $artwork->title }}</h1>
                        <div><a href="{{ route('frontend.artist.profile', $artwork->user->username) }}">{{ $artwork->user->name }}</a></div>
                        @if (!empty($artwork->materials_used))
                        <p class="mt-2">
                            <b>@lang('Materials used')</b> : {!! nl2br(e($artwork->materials_used)) !!}
                        </p>
                        @endif
                        @if (!empty($artwork->tools))
                        <p class="mt-2">
                            <b>@lang('Tools')</b> : {!! nl2br(e($artwork->tools)) !!}
                        </p>
                        @endif
                        <p class="mt-2">
                            <b>@lang('Outer frame')</b> : {{ $artwork->outer_frame ? __('Yes') : __('No') }}
                        </p>
                        <p class="mt-2">
                            <b>@lang('Painting dimensions (CM)')</b> : {!! nl2br(e($artwork->dimensions)) !!}
                        </p>
                        <p class="mt-2">
                            <b>@lang('Outer frame')</b> : {{ $artwork->covered_with_glass ? __('Yes') : __('No') }}
                        </p>
                        @if (!empty($artwork->tools))
                        <p class="mt-2">
                            <b>@lang('Artwork location')</b> : {!! nl2br(e($artwork->location)) !!}
                        </p>
                        @endif

                        <p class="mt-2">
                            <b>@lang('Painting status')</b> : {{ $artwork->status_text }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
