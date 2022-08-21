@extends('Frontend.Layout.app')
@section('content')
    <section class="breadcrumb_ bg-white pt-5 pb-0">
        <div class="container">
            <h1 class="mb-2">{{ $exhibition->name }}</h1>
            <nav aria-label="breadcrumb" class="mb-0">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">@lang('Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('frontend.exhibitions.index') }}">@lang('Exhibitions')</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:;">{{ $exhibition->name }}</a></li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="exhibition-page bg-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-6 mb-5">
                    <div class="d-flex">
                        <div class="pe-3">
                            <div class="pic-w100">
                                <img src="{{storage_url($exhibition->sponsor->logo)}}" alt="" class="pic-w100">
                            </div>
                        </div>
                        <div>
                            <style>
                                .sponsor-infoo li {
                                    word-break: break-word;
                                }
                            </style>
                            <h3 class="text-primary">{{$exhibition->name}}</h3>
                            <h5>@lang('Sponsor'): </h5>
                            <ul class="ps-3 list-unstyled sponsor-infoo">
                                <li>
                                    <i class="fa fa-handshake"></i>
                                    <span>{{$exhibition->sponsor->name}}</span>
                                </li>
                                <li>
                                    <i class="fa fa-link"></i>
                                    <span><a href="{{$exhibition->sponsor->website}}" target="_blank">{{$exhibition->sponsor->website}}</a></span>
                                </li>
                                <li>
                                    <i class="fa fa-globe"></i>
                                    <span>{{__(country($exhibition->sponsor->country)->getName())}}</span>
                                </li>
                                @if (!empty($exhibition->sponsor->phone))
                                <li>
                                    <i class="me-1 bi bi-telephone"></i> <span><a href="tel:{{$exhibition->sponsor->phone}}">{{$exhibition->sponsor->phone}}</a></span>
                                </li>
                                @endif
                                @if (!empty($exhibition->sponsor->email))
                                <li>
                                    <i class="me-1 bi bi-envelope"></i> <span><a href="mailto:{{$exhibition->sponsor->email}}">{{$exhibition->sponsor->email}}</a></span>
                                </li>
                                @endif
                                @if (!empty($exhibition->sponsor->address))
                                <li>
                                    <i class="me-1 bi bi-geo-alt"></i> <span>{{str($exhibition->sponsor->address)->limit(40)}}</span>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="table-reponsive">
                        <table class="table" width="100%">
                            <tr>
                                <td scope="row">@lang('Exhibition name')</td>
                                <td class="text-end">{{ $exhibition->name }}</td>
                            </tr>
                            <tr>
                                <td scope="row">@lang('Date')</td>
                                <td class="text-end">{{ $exhibition->from_to_date }}</td>
                            </tr>
                            <tr>
                                <td scope="row">@lang('Country')</td>
                                <td class="text-end">{{ __(country($exhibition->country)->getName()) }}</td>
                            </tr>
                            <tr>
                                <td scope="row">@lang('City')</td>
                                <td class="text-end">{{ $exhibition->city }}</td>
                            </tr>
                            <tr>
                                <td scope="row">@lang('Registration url')</td>
                                <td class="text-end"><a target="_blank" href="{{ $exhibition->registration_url }}">{{ __('Registration url') }}</a></td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
