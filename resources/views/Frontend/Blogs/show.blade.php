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
                        <small> <i class="far fa-clock me-1"></i>
                            {{ $blog->created_at->translatedFormat('l d F Y على الساعة h:i A') }}</small>
                        <h3 class="mt-4">{{ $blog->title }}</h3>
                        <div class="bg-light p-3 pb-2 shadow-sm my-2">
                            <h5><a
                                    href="{{ route('frontend.artist.profile', [$blog->user->username, 'blogs']) }}">{{ $blog->user->name }}</a>
                            </h5>
                        </div>
                        <div class="blog-content py-3">
                            <div class="blog-image">
                                <div class="w-100">
                                    <img src="{{ storage_url($blog->image) }}"
                                        alt="{{ $blog->image_description ?: $blog->title }}">
                                </div>
                            </div>
                            {!! cleanHtml($blog->body) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="py-2">
                        <h4>@lang('Latest blogs from :name', ['name' => explode(' ', $blog->user->name)[0]])</h4>

                        @forelse ($blog->user->news()->published()->where('id', '!=', $blog->id)->latest()->take(7)->get() as $blog_)
                            @if ($loop->first)
                                <div class="blogs-list">
                            @endif
                            <div class="blog-item mb-md-3 mb-2">
                                <div class="bg-light p-3 rounded h-100">
                                    <div>
                                        <div class="blog-item-data">
                                            <h5 class="text-primary mb-1 blog-item-title"><a
                                                    href="{{ route('frontend.blogs.show', $blog_->slug) }}">{{ $blog_->title }}</a>
                                            </h5>
                                            <p class="mb-2">{{ str(strip_tags($blog_->body))->limit(71) }}</p>
                                            <div class="info mb-0">
                                                <ul class="d-flex p-0 text-secondary mb-0 flex-wrap"
                                                    style="list-style: none;gap:12px;font-size:14px;">
                                                    <li>
                                                        <i class="me-1 bi bi-person"></i>
                                                        <span>{{ str($blog->user->name)->limit(30) }}</span>
                                                    </li>
                                                    <li title="{{ $blog_->created_at->translatedFormat('d M Y H:i') }}">
                                                        <i class="me-1 bi bi-clock"></i>
                                                        <span>{{ $blog_->created_at->diffForHumans() }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($loop->last)
                                </div>
                                <div class="text-center mt-4">
                                    <a href="{{route('frontend.artist.profile', [$blog->user->username, 'blogs'])}}" class="primary-btn">@lang('Show all blogs')</a>
                                </div>
                            @endif
                    @empty
                    <div class="text-center py-5">
                        <h1 style="font-size: 90px;"><i class="bi bi-quote"></i></h1>
                        <p>@lang("There's no more blogs").</p>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
