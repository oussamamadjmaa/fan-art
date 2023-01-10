@extends('Frontend.Layout.app')
@section('content')
    <section class="bg-white py-4">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:;">@lang('My Orders')</a></li>
                </ol>
            </nav>

            @if ($orders->count())
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('Artwork')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Payment Method')</th>
                            <th>@lang('Order Status')</th>
                            <th>@lang('Last update')</th>
                            <th>@lang('Order date')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>
                                    <a href="{{ route('frontend.artworks.show', $order->orderable->slug) }}">
                                        <img src="{{ route('image_resize', [300, $order->orderable->image]) }}" alt="{{ $order->orderable->title }}" width="41" height="41" class="me-2">
                                        <span>{{ $order->orderable->title }}</span>
                                    </a>
                                </td>
                                <td>{{ $order->amount }} @lang(config('app.currency'))</td>
                                <td>{{ __('payment_methods.'.$order->payment_method.'.title') }}</td>
                                <td><x-badges.order-status :order="$order" /></td>
                                <td>{{ $order->updated_at->translatedFormat('d M Y h:i A') }}</td>
                                <td>{{ $order->created_at->translatedFormat('d M Y h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-3">
                لا يوجد لديك أي طلب حاليا
            </div>
            @endif
        </div>
    </section>
@endsection
