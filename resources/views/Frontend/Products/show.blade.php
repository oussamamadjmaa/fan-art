@extends('Frontend.Layout.app')
@section('content')
    {{-- Artworks --}}
    <section class="products bg-white py-4">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">@lang('Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{route('frontend.store.profile', $product->user->username)}}">{{$product->user->name}}</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:;">{{ $product->name }}</a></li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-md-6 col-lg-7">
                    <div class="product-page-image px-md-3 mb-md-0 mb-3">
                        <img src="{{ storage_url($product->image) }}"
                            alt="{{ $product->name }} - {{ $product->user->name }}"
                            style="width:100%;height:100%;object-fit:contain;max-height:600px;"
                            data-zoom-image="{{ storage_url($product->image) }}" id="product_img_01">
                    </div>
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="text-start">
                        <h1 class="fs-3 mb-0">{{ $product->name }}</h1>
                        <div><a
                                href="{{ route('frontend.store.profile', $product->user->username) }}">{{ $product->user->name }}</a>
                        </div>

                        <div class="mt-2">

                            <p class="mt-2">
                                {!! nl2br(e($product->category->name)) !!}
                            </p>
                            <p class="mt-2">
                                {!! nl2br(e($product->description)) !!}
                            </p>
                        </div>
                        <h3 class="text-primary py-3">{{ price_format($product->price) }}
                            <small><sup>@lang(config('app.currency'))</sup></small></h3>

                        @if (!auth()->check() || auth()->id() != $product->user_id)
                        <div class="buttons">
                            <a href="javascript:;" class="primary-btn" data-bs-toggle="modal"
                                data-bs-target="#productContactModal">@lang('Contact store')</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="row">
                    <div class="col-12 border-top">
                        <div class="container py-md-5 py-3 border-bottom">
                            <div class="d-flex overflow-hidden">
                                <div class="me-md-5 me-3">
                                    <div class="avatar-150">
                                        <img src="{{ $product->user->avatar_url }}" alt="{{$product->user->name}}" class="avatar-150">
                                    </div>
                                </div>
                                <div class="store-profile-info flex-grow-1">
                                    <div class="d-md-flex flex-wrap py-2" style="gap: 1.6rem;">
                                        <div>
                                            <h5 class="store-name">{{ $product->user->name }}</h5>
                                            <h6>{{ __(country($product->user->country)->getName()) }}</h6>
                                        </div>
                                    </div>
                                    <div class="d-ph-none">
                                        <p>{{ $product->user->address }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-pc-none mt-3">
                                <p>{{ $product->user->address }}</p>
                            </div>
                        </div>
                    </div>

                    @php
                        $store_products = $product->user->products()->where('id', '!=', $product->id)->with('category')->take(8)->get();
                    @endphp
                    @if ($store_products->count())
                    <div class="col-12 border-top py-5">
                        <h4 class="mb-4">@lang("Here's more products from :name you may like", ['name' => explode(' ', $product->user->name)[0]])</h4>
                        <div>
                            @foreach ($store_products as $product_)
                                @if ($loop->first)
                                    <div class="products-grid row">
                                @endif
                                <div class="product-grid-item mb-md-3 mb-2 col-lg-3 col-md-4 col-sm-6 col-12">
                                    @include('Frontend.Products.partials.single', ['product' => $product_])
                                </div>
                                @if ($loop->last)
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="text-center my-5">
                            <a href="{{ route('frontend.store.profile', $product->user->username) }}" class="primary-btn">@lang('View all products')</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @if (!auth()->check() || auth()->id() != $product->user_id)
    <!-- Modal -->
    <div class="modal fade" id="productContactModal" tabindex="-1" role="dialog" aria-labelledby="productContactModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 699px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Send message to store')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex text-start">
                        <div>
                            <div class="pic-w100">
                                <img src="{{ storage_url($product->image) }}"
                                    alt="{{ $product->name }} - {{ $product->user->name }}" class="pic-w100">
                            </div>
                        </div>
                        <div class="ps-3">
                            <h6><a
                                    href="{{ route('frontend.store.profile', $product->user->username) }}">{{ $product->user->name }}</a>
                            </h6>
                            <h6>{{ $product->name }}</h6>
                        </div>
                    </div>

                    <div class="mt-3">
                        <form data-action="{{route('frontend.products.send_message', $product->id)}}" method="POST" id="product_message_form">
                            @csrf
                            <div class="mb-3">
                                <label for="message" class="form-label">@lang('Message')</label>
                                <textarea class="form-control" name="message" id="message" rows="3" required>@lang("Hi, I'm interested in purchasing this product. Could you please provide more information about it?")</textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                            @guest
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">@lang('First name')</label>
                                        <input type="text" class="form-control" name="first_name" id="first_name"
                                            placeholder="@lang('First name')" required>
                                            <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">@lang('Last name')</label>
                                        <input type="text" class="form-control" name="last_name" id="last_name"
                                            placeholder="@lang('Last name')" required>
                                            <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">@lang('Email Address')</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="@lang('Email Address')" required>
                                    <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">@lang('Phone')</label>
                                <input type="text" class="form-control" name="phone" id="phone" required
                                    placeholder="@lang('Phone')">
                                    <div class="invalid-feedback"></div>
                            </div>
                            @endguest

                            <button class="primary-btn pt-2 pb-1 px-3" id="send_btn">
                                @lang('Send message')
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('vendors/jquery/js/jquery-ez-plus.js') }}" defer></script>
     @vite(['resources/frontend-assets/js/pages/product.js'])
@endpush
