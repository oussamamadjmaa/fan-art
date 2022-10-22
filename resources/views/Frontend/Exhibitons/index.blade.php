@extends('Frontend.Layout.app')
@section('content')
    <section class="breadcrumb_ bg-white pt-5 pb-0">
        <div class="container">
            <h1 class="mb-2">@lang('Exhibitions')</h1>
            <nav aria-label="breadcrumb" class="mb-0">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{route('frontend.home')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:;">@lang('Exhibitions')</a></li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="exhibitions-page bg-white py-5">
        <div class="container">
            <div class="border-bottom py-2">
                <p class="mb-0">تم العثور على <b>{{$exhibitions->total()}}</b> نتائج</p>
            </div>
            <div class="exhibitions-list">
                @forelse ($exhibitions as $exhibition)
                <div>
                    <div class="exhibition-item border-bottom py-3">
                        <div class="exhibition-info">
                            <h5 class="mb-2"><a href="{{route('frontend.exhibitions.show', $exhibition->slug)}}">{{$exhibition->name}}</a></h5>
                            <div class="info mb-0">
                                <ul class="d-flex p-0 text-secondary mb-0 flex-wrap" style="list-style: none;gap:12px;font-size:11px;">
                                    <li>
                                        <i class="me-1 bi bi-person"></i> <span>{{str($exhibition->user->name)->limit(30)}}</span>
                                    </li>

                                    @if ($exhibition->sponsor)
                                    <li>
                                        <i class="me-1 far fa-handshake"></i> <span>{{$exhibition->sponsor->name}}</span>
                                    </li>
                                    @endif
                                    <li>
                                        <i class="me-1 bi bi-geo-alt"></i> <span>{{__(country($exhibition->country)->getName())}}, {{$exhibition->city}}</span>
                                    </li>
                                    <li>
                                        <i class="me-1 bi bi-clock"></i> <span>{{$exhibition->from_to_date}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="text-center pt-5">
                        <h1 style="font-size: 90px;"><i class="bi bi-calendar-event"></i></h1>
                        <p>@lang("There's no exhibitions yet").</p>
                    </div>
                @endforelse
            </div>
            @if (!empty(trim($exhibitions->links())))
                <div class="text-center d-flex justify-content-center py-4">
                    {{$exhibitions->withQueryString()->onEachSide(0)->links()}}
                </div>
            @endif
        </div>
    </section>
@endsection
