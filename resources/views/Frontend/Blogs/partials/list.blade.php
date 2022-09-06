@forelse ($artists_with_last_blog->sortByDesc('latest_blog.created_at') as $artist_)
    @if ($loop->first)
        <div class="blogs-list pb-2 row">
    @endif
    <div class="blog-item mb-md-3 mb-2 col-lg-4 col-md-6">
        <div class="bg-light p-2 rounded h-100">
            <div class="d-sm-flex h-100">
                <div class="d-flex pe-2 justify-content-center mb-md-0 mb-2">
                    <a class="d-block" href="{{route('frontend.artist.profile', [$artist_->username, 'blogs'])}}">
                        <div class="avatar-75 text-center">
                            <img src="{{$artist_->avatar_url}}" alt="{{ $artist_->name }}" class="avatar-75">
                        </div>
                        <h6 class="mt-1 mb-0" style="white-space: nowrap;text-overflow:ellipsis;overflow:hidden">{{$artist_->name}}</h6>
                    </a>
                </div>
                <div class="blog-item-data">
                    <h5 class="text-primary mb-1 blog-item-title"><a href="{{route('frontend.blogs.show', $artist_->latest_blog->slug)}}">{{ $artist_->latest_blog->title }}</a></h5>
                    <p class="mb-2">{{ str(strip_tags($artist_->latest_blog->body))->limit(71) }}</p>
                    <div class="info mb-0">
                        <ul class="d-flex p-0 text-secondary mb-0 flex-wrap" style="list-style: none;gap:12px;font-size:14px;">
                            {{-- <li>
                                <i class="me-1 bi bi-person"></i> <span>{{str($artist_->name)->limit(30)}}</span>
                            </li> --}}
                            <li title="{{$artist_->latest_blog->created_at->translatedFormat('D d M Y H:i')}}">
                                <i class="me-1 bi bi-clock"></i> <span>{{$artist_->latest_blog->created_at->translatedFormat('D d M Y')}}</span>
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
