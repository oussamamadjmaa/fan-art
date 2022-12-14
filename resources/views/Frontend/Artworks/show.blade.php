@extends('Frontend.Layout.app')
@section('content')
    {{-- Artworks --}}
    <section class="artworks bg-white py-4">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">@lang('Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('frontend.artworks.index') }}">@lang('Paintings and artwork')</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:;">{{ $artwork->title }}</a></li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-md-6 col-lg-7">
                    <div class="artwork-page-image px-md-3 mb-md-0 mb-3">
                        <img src="{{ route('image_resize', [900, $artwork->image]) }}"
                            alt="{{ $artwork->title }} - {{ $artwork->user->name }}"
                            style="width:100%;height:100%;object-fit:contain;max-height:600px;"
                            data-zoom-image="{{ route('image_resize', [900, $artwork->image]) }}" id="artwork_img_01">
                    </div>
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="text-center">
                        <h1 class="fs-3 mb-0">{{ $artwork->title }}</h1>
                        <div><a
                                href="{{ route('frontend.artist.profile', $artwork->user->username) }}">{{ $artwork->user->name }}</a>
                        </div>

                        <div class="mt-5">

                            <p class="mt-2">
                                <b>@lang('Painting type')</b> : {!! nl2br(e($artwork->type)) !!}
                            </p>
                            <p class="mt-2">
                                <b>@lang('Outer frame')</b> : {{ $artwork->outer_frame ? __('Yes') : __('No') }}
                            </p>
                            <p class="mt-2">
                                <b>@lang('Painting dimensions (CM)')</b> : {!! nl2br(e($artwork->dimensions)) !!}
                            </p>
                            @if (!empty($artwork->location))
                                <p class="mt-2">
                                    <b>@lang('Artwork location')</b> : {!! nl2br(e($artwork->location)) !!}
                                </p>
                            @endif
                            <p class="mt-2">
                                <b>@lang('Painting status')</b> : {{ $artwork->status_text }}
                            </p>
                        </div>
                        <h3 class="text-primary py-3">{{ price_format($artwork->price) }}
                            <small><sup>@lang(config('app.currency'))</sup></small></h3>

                        <div class="d-flex flex-wrap justify-content-center" style="gap: 1rem;">
                            @if (!auth()->check() || auth()->id() != $artwork->user_id)
                            <div class="buttons">
                                <a href="javascript:;" class="primary-btn" data-bs-toggle="modal"
                                    data-bs-target="#artworkContactModal">@lang('Contact artist')</a>
                            </div>
                            @endif

                            {{-- @if($artwork->url) --}}
                            <div class="buttons">
                                {{-- {{ $artwork->url }} --}}
                                <a href="javascript:;" data-bs-toggle="modal"
                                data-bs-target="#artworkBuyModal" class="primary-btn">@lang('????????')</a>
                            </div>
                            {{-- @endif --}}
                        </div>
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
                                        <img src="{{ $artwork->user->avatar_url }}" alt="{{$artwork->user->name}}" class="avatar-150">
                                    </div>
                                </div>
                                <div class="artist-profile-info flex-grow-1">
                                    <div class="d-md-flex flex-wrap py-2" style="gap: 1.6rem;">
                                        <div>
                                            <h5 class="artist-name">{{ $artwork->user->name }}</h5>
                                            <h6>{{ __(country($artwork->user->country)->getName()) }}, {{ __($artwork->user->nationality) }}</h6>
                                        </div>
                                    </div>
                                    <div class="d-ph-none">
                                        <p>{{ $artwork->user->profile?->bio }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-pc-none mt-3">
                                <p>{{ $artwork->user->profile?->bio }}</p>
                            </div>
                        </div>
                    </div>

                    @php
                        $artist_artworks = $artwork->user->artworks()->where('id', '!=', $artwork->id)->take(4)->get();
                    @endphp
                    @if ($artist_artworks->count())
                    <div class="col-12 border-top py-5">
                        <h4 class="mb-4">@lang("Here's more artworks and paintings from :name you may like", ['name' => explode(' ', $artwork->user->name)[0]])</h4>
                        <div>
                            @foreach ($artist_artworks as $artwork_)
                                @if ($loop->first)
                                    <div class="artworks-grid">
                                @endif
                                <div class="artwork-grid-item mb-md-3 mb-2">
                                    @include('Frontend.partials.artwork.single', ['artwork' => $artwork_])
                                </div>
                                @if ($loop->last)
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="text-center my-5">
                            <a href="{{ route('frontend.artist.profile', $artwork->user->username) }}" class="primary-btn">@lang('View all artworks')</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @if (!auth()->check() || auth()->id() != $artwork->user_id)
    <!-- Contant Modal -->
    <div class="modal fade" id="artworkContactModal" tabindex="-1" role="dialog" aria-labelledby="artworkContactModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 699px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Send message to artist')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex text-start">
                        <div>
                            <div class="pic-w100">
                                <img src="{{ route('image_resize', [300, $artwork->image]) }}"
                                    alt="{{ $artwork->title }} - {{ $artwork->user->name }}" class="pic-w100">
                            </div>
                        </div>
                        <div class="ps-3">
                            <h6><a
                                    href="{{ route('frontend.artist.profile', $artwork->user->username) }}">{{ $artwork->user->name }}</a>
                            </h6>
                            <h6>{{ $artwork->title }}</h6>
                        </div>
                    </div>

                    <div class="mt-3">
                        <form data-action="{{route('frontend.artworks.send_message', $artwork->id)}}" method="POST" id="artwork_message_form">
                            @csrf
                            <div class="mb-3">
                                <label for="message" class="form-label">@lang('Message')</label>
                                <textarea class="form-control" name="message" id="message" rows="3" required>@lang("Hi, I'm interested in purchasing this work. Could you please provide more information about the piece?")</textarea>
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
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="phone" class="form-label">@lang('Phone')</label>
                                    <input type="text" class="form-control" name="phone" id="phone" required
                                        placeholder="@lang('Phone')">
                                        <div class="invalid-feedback"></div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="whatsapp_number" class="form-label">@lang('?????? ???????? ????????????')</label>
                                    <input type="text" class="form-control" name="whatsapp_number" id="whatsapp_number" dir="ltr" required
                                        placeholder="@lang('?????? ???????? ????????????')">
                                        <div class="invalid-feedback"></div>
                                </div>
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

    <!-- Buy Modal -->
    <div class="modal fade" id="artworkBuyModal" tabindex="-1" role="dialog" aria-labelledby="artworkBuyModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 699px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Order buy artwork')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex text-start">
                        <div>
                            <div class="pic-w100">
                                <img src="{{ route('image_resize', [300, $artwork->image]) }}"
                                    alt="{{ $artwork->title }} - {{ $artwork->user->name }}" class="pic-w100">
                            </div>
                        </div>
                        <div class="ps-3">
                            <h6><a
                                    href="{{ route('frontend.artist.profile', $artwork->user->username) }}">{{ $artwork->user->name }}</a>
                            </h6>
                            <h6>{{ $artwork->title }}</h6>
                            <h4 class="text-primary">{{ price_format($artwork->price) }}
                                <small><sup>@lang(config('app.currency'))</sup></small></h4>
                        </div>
                    </div>

                    <div class="mt-3">
                        @auth
                            <form data-action="{{route('frontend.artworks.order', $artwork->id)}}" method="POST" id="artwork_order_form">
                                @csrf

                                <div class="mb-3">
                                    <label for="bank_transfer_receipt" class="form-label">@lang('Upload bank transfer receipt')</label>
                                    <input type="file" class="form-control @error('bank_transfer_receipt') is-invalid @enderror" name="bank_transfer_receipt" id="bank_transfer_receipt" aria-describedby="helpReceipt" required>
                                      @error('bank_transfer_receipt')
                                          <div class="invalid-feedback">{{ $message }}</div>
                                      @enderror
                                      {{-- <small id="helpReceipt">?????????? ?????? ?????? ???? ?????? ?????????????? ??????????</small> --}}
                                  </div>

                                  <div class="bg-light p-3 mt-3 mb-2">
                                    <table width="100%">
                                        <tr>
                                            <td width="50%" class="text-secondary">@lang('Bank')</td>
                                            <td>{{config('app.bank.name', __('Uknown'))}}</td>
                                        </tr>
                                        <tr>
                                            <td width="50%" class="text-secondary">@lang('Account holder')</td>
                                            <td>{{config('app.bank.account_holder', __('Uknown'))}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-secondary">@lang('Account number')</td>
                                            <td>{{config('app.bank.account_number', __('Uknown'))}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-secondary">@lang('IBAN number')</td>
                                            <td>{{config('app.bank.IBAN', __('Uknown'))}}</td>
                                        </tr>
                                    </table>
                                </div>

                                <button class="primary-btn pt-2 pb-1 px-3" id="order_btn">
                                    @lang('Order')
                                </button>
                            </form>
                        @else
                            <div class="d-flex justify-content-center py-4" style="gap: .5rem">
                                <a href="{{ route('login') }}">@lang('Login')</a>
                                <p>????</p>
                                <a href="{{ route('register', ['customer', 'redirect_to' => request()->fullUrl()]) }}">@lang('Register')</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('vendors/jquery/js/jquery-ez-plus.js') }}" defer></script>
     @vite(['resources/frontend-assets/js/pages/artwork.js'])
@endpush
