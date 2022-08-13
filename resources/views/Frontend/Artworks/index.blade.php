@extends('Frontend.Layout.app')
@section('content')
    {{-- Artworks --}}
    <section class="artworks bg-white py-5">
        <div class="container">
            <h1 class="mb-2">@lang('Paintings and artwork')</h1>
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('frontend.home')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:;">@lang('Paintings and artwork')</a></li>
                </ol>
            </nav>
            @include('Frontend.Artworks.partials.artworks')
            @if (!empty(trim($artworks->links())))
                <div class="text-center d-flex justify-content-center py-4">
                    {{$artworks->withQueryString()->onEachSide(0)->links()}}
                </div>
            @endif
        </div>
    </section>
@endsection
