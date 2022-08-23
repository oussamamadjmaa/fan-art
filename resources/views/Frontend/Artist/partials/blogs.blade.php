@forelse ($artist_blogs as $blog)
    @if ($loop->first)
        <div class="blogs-list pb-2 row">
    @endif
    <div class="blog-item mb-md-3 mb-2 col-lg-6">
        <div class="bg-light p-3 rounded h-100">
            <div class="d-sm-flex h-100">
                <div class="blog-item-pic d-none d-sm-flex pe-3">
                    <div class="pic-w150">
                       <a class="d-block" href="{{route('frontend.blogs.show', $blog->slug)}}">
                            <img src="{{storage_url($blog->image)}}" alt="{{ $blog->image_description ?: $blog->title }}" class="pic-w150" style="max-height: 150px;object-fit:cover;">
                       </a>
                    </div>
                </div>
                <div class="blog-item-data">
                    <h5 class="text-primary mb-1 blog-item-title"><a href="{{route('frontend.blogs.show', $blog->slug)}}">{{ $blog->title }}</a></h5>
                    <p class="mb-2">{{ str(strip_tags($blog->body))->limit(210) }}</p>
                    <div class="info mb-0">
                        <ul class="d-flex p-0 text-secondary mb-0 flex-wrap" style="list-style: none;gap:12px;font-size:14px;">
                            <li>
                                <i class="me-1 bi bi-person"></i> <span>{{str($blog->user->name)->limit(30)}}</span>
                            </li>
                            <li title="{{$blog->created_at->translatedFormat('d M Y H:i')}}">
                                <i class="me-1 bi bi-clock"></i> <span>{{$blog->created_at->diffForHumans()}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($loop->last)
        </div>
    @endif
@empty
    <div class="text-center py-5">
        <h1 style="font-size: 90px;"><i class="bi bi-quote"></i></h1>
        @if ($artist->id == auth()->id())
            <p>@lang("You didn't post any blog yet").</p>
            <a href="{{ route('backend.blogs.index') }}">@lang('Add Blog')</a>
        @else
            <p>@lang("This artist didn't post any blog yet").</p>
        @endif
    </div>
@endforelse
