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
            @if ($artworks->count())
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
            @include('Frontend.Artworks.partials.artworks')
            @if (!empty(trim($artworks->links())))
                <div class="text-center d-flex justify-content-center py-4">
                    {{$artworks->withQueryString()->onEachSide(0)->links()}}
                </div>
            @endif
        </div>
    </section>
@endsection
