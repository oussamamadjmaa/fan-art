@extends('Frontend.Layout.app')
@section('content')
    <section class="bg-white blog-page py-4">
        <div class="container">
            <h1 class="mb-2">@lang('Artist blog')</h1>
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">@lang('Home')</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">@lang('Artist blog')</a></li>
                </ol>
            </nav>

        </div>
    </section>

    <section class="blogs-page bg-white">
        <div class="container">
            @include('Frontend.Blogs.partials.list')
            @if (!empty(trim($artists_with_last_blog->links())))
                <div class="text-center d-flex justify-content-center py-4">
                    {{$artists_with_last_blog->withQueryString()->onEachSide(0)->links()}}
                </div>
            @endif
        </div>
    </section>
@endsection
