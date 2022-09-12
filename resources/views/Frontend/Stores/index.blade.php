@extends('Frontend.Layout.app')
@section('content')
    {{-- Artworks --}}
    <section class="stores-page bg-white py-5">
        <div class="container">
            <h1 class="mb-2">@lang('Stores')</h1>
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('frontend.home')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:;">@lang('Stores')</a></li>
                </ol>
            </nav>

            <div class="stores-list">
                @forelse ($stores as $store)
                <div class="stores-list-item mb-5">
                    <div class="row">
                        <div class="col-md-3 mb-3 mb-md-0">
                            <div class="store-information">
                                <div>
                                    <a class="store-showcase_ text-dark" href="{{ route('frontend.store.profile', $store->username) }}">
                                        <div class="store-showcase_-avatar mb-3 avatar-150 mx-auto">
                                            <img src="{{ $store->avatar_url }}" alt="{{ $store->name }}" class="avatar-150">
                                        </div>
                                        <div class="store-showcase_-info text-center">
                                            <h5>{{ str($store->name)->limit(30) }}</h5>
                                            <h6>{{ __(country($store->country)->getName()) }}</h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @forelse ($store->products()->with('category')->latest()->limit(3)->get() as $product)
                        <div class="col-md-3 col-sm-6 @if(!$loop->first) d-none d-sm-block @endif">
                            <div>
                                @include('Frontend.Products.partials.single')
                            </div>
                        </div>
                        @empty
                            <div class="col">
                                <div class="text-center h-100 d-flex align-items-center justify-content-center">
                                    <h6>@lang("This store doesn't have any products yet")</h6>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <h1 style="font-size: 90px;"><i class="bi bi-palette"></i></h1>
                    <p>@lang("There's no stores yet").</p>
                </div>
                @endforelse
            </div>
            @if (!empty(trim($stores->links())))
                <div class="text-center d-flex justify-content-center py-4">
                    {{$stores->withQueryString()->onEachSide(0)->links()}}
                </div>
            @endif
        </div>
    </section>
@endsection
