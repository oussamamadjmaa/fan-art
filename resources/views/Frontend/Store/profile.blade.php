@extends('Frontend.Layout.app')
@section('content')
    <section class="store-profile-header bg-white">
        <div class="container py-md-5 py-3 border-bottom">
            <div class="d-flex overflow-hidden">
                <div class="me-md-5 me-3">
                    <div class="avatar">
                        <img src="{{ $store->avatar_url }}" alt="{{ $store->name }}' avatar" class="avatar">
                    </div>
                </div>
                <div class="store-profile-info flex-grow-1">
                    <div class="d-md-flex flex-wrap py-2" style="gap: 1.6rem;">
                        <div>
                            <h5 class="store-name">{{ $store->name }}</h5>
                            <h6>{{ __(country($store->country)->getName()) }}</h6>
                        </div>
                    </div>
                    <div class="d-ph-none">
                        <p>{{ $store->address }}</p>
                    </div>
                    <div>
                        <ul class="store-contact-info list-unstyled">
                            @if ($store->website)
                            <li>
                                <a class="text-dark" title="@lang('Website')" target="_blank" href="{{$store->website}}"><i class="fa fa-link"></i> <span dir="ltr">{{str_replace(['http://', 'https://'], '',$store->website)}}</span></a>
                            </li>
                            @endif
                            @if ($store->email && $store->profile?->privacy_settings?->show_email)
                            <li>
                                <a class="text-dark" title="@lang('Email')" href="mailto:{{$store->email}}"><i class="fa fa-envelope"></i> {{$store->email}}</a>
                            </li>
                            @endif
                            @if ($store->phone && $store->profile?->privacy_settings?->show_phone)
                            <li>
                                <a class="text-dark" title="@lang('Phone')" href="tel:{{$store->phone}}"><i class="fa fa-phone"></i>  <span dir="ltr">{{$store->phone}}</span></a>
                            </li>
                            @endif
                        </ul>
                        <ul class="store-social-media-links d-flex flex-wrap list-unstyled">
                            @if (!empty($store->profile?->social_media['whatsapp']))
                            <li>
                                <a title="@lang('Whatsapp')" href="https://wa.me/{{$store->profile->social_media['whatsapp']}}" target="_blank"><i class="fab fa-whatsapp"></i></a>
                            </li>
                            @endif
                            @if (!empty($store->profile?->social_media['facebook']))
                            <li>
                                <a title="@lang('Facebook')" href="{{$store->profile->social_media['facebook']}}" target="_blank"><i class="fab fa-facebook"></i></a>
                            </li>
                            @endif
                            @if (!empty($store->profile?->social_media['instagram']))
                            <li>
                                <a title="@lang('Instagram')" href="{{$store->profile->social_media['instagram']}}" target="_blank"><i class="fab fa-instagram"></i></a>
                            </li>
                            @endif
                            @if (!empty($store->profile?->social_media['twitter']))
                            <li>
                                <a title="@lang('Twitter')" href="{{$store->profile->social_media['twitter']}}" target="_blank"><i class="fab fa-twitter"></i></a>
                            </li>
                            @endif
                            @if (!empty($store->profile?->social_media['linkedin']))
                            <li>
                                <a  title="@lang('Linkedin')"href="{{$store->profile->social_media['linkedin']}}" target="_blank"><i class="fab fa-linkedin"></i></a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="d-pc-none mt-3">
                <p>{{ $store->address }}</p>
            </div>
        </div>
    </section>

    {{-- Store Products --}}
    <section class="store_products bg-white">
        <div class="container py-4">
            <div>
                <div class="d-flex flex-wrap justify-content-between">
                    <div class="dropdown open mb-4">
                        <a class="bg-light d-block text-dark p-2 pb-1" href="javascript:;" type="button" id="categoryIdS" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bi bi-tag"></i> @lang('Category'): {{$category?->name ?? __('All')}}
                                </a>
                        <div class="dropdown-menu" aria-labelledby="categoryIdS">
                            <a class="dropdown-item" href="{{request()->fullUrlWithQuery(['categoryId' => NULL])}}">@lang('All')</a>
                            @foreach ($categories as $category_)
                                <a class="dropdown-item" href="{{request()->fullUrlWithQuery(['categoryId' => $category_->id])}}">@lang($category_->name)</a>
                            @endforeach
                        </div>
                    </div>

                    <div class="dropdown open mb-4">
                        <a class="bg-light d-block text-dark p-2 pb-1" href="javascript:;" type="button" id="sortBy" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                   <i class="bi bi-filter"></i> @lang('Sort by'): @lang($sortByList[$currentSortBy] ?? 'Latest')
                                </a>
                        <div class="dropdown-menu" aria-labelledby="sortBy">
                            @foreach ($sortByList as $sortByKey => $sortByText)
                                <a class="dropdown-item" href="{{request()->fullUrlWithQuery(['sortBy' => $sortByKey])}}">@lang($sortByText)</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @include('Frontend.Store.partials.products')
            @if (!empty(trim($store_products->links())))
                <div class="text-center d-flex justify-content-center py-4">
                    {{$store_products->withQueryString()->onEachSide(0)->links()}}
                </div>
            @endif
        </div>
    </section>
@endsection
