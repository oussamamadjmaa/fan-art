@extends('Frontend.Layout.app')
@section('content')
    <section class="bg-white blog-page py-4">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">@lang('Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('frontend.blogs.index') }}">@lang('Blog')</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:;">{{ str($blog->title)->limit(60) }}</a></li>
                </ol>
            </nav>
            <div class="row border-top py-2">
                <div class="col-md-9">
                    <div class="blog-container">
                        <small> <i class="far fa-clock me-1"></i> {{ $blog->created_at->translatedFormat('D d F Y على الساعة h:i A') }}</small>
                        <h3 class="mt-4">{{ $blog->title }}</h3>
                        <div class="bg-light p-3 pb-2 shadow-sm my-2">
                            <h5><a href="{{ route('frontend.artist.profile', [$blog->user->username, 'blogs']) }}">{{ $blog->user->name }}</a></h5>
                        </div>
                        <div class="blog-content py-3">
                            <div class="blog-image">
                                <div class="w-100">
                                    <img src="{{storage_url($blog->image)}}" alt="{{ $blog->image_description ?: $blog->title }}">
                                </div>
                            </div>
                            {!! cleanHtml($blog->body) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    dz
                </div>
            </div>
        </div>
    </section>
@endsection
