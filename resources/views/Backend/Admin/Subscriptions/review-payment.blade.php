@extends('Backend.Layout.master', ['title' => __('Review Payment')])
@section('content')
@php
    $user_ = $payment->user;
@endphp
<div class="card">
    <div class="card-body pb-0">
        @if (session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
        @endif
        {{-- Subscription and payment information --}}
        <div>
            <h3>@lang('Subscription and payment information'):</h3>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td>#ID</td>
                        <td>{{$payment->id}}</td>
                    </tr>

                    <tr>
                        <td>@lang('Payment Method')</td>
                        <td>{{ __('payment_methods.'.$payment->payment_method.'.title') }}</td>
                    </tr>
                    <tr>
                        <td>@lang('Plan name')</td>
                        <td>{{ $payment->paymentable->name }}</td>
                    </tr>
                    <tr>
                        <td>@lang('Duration')</td>
                        <td>{{ $payment->payment_data['duration'] }} @lang($payment->payment_data['duration_type'])</td>
                    </tr>
                    <tr>
                        <td>@lang('Amount')</td>
                        <td>{{ price_format($payment->amount) }} @lang(config('app.currency'))</td>
                    </td>
                    <tr>
                        <td>@lang('Payment Status')</td>
                        <td><span class="badge bg-{{ $payment->status_color }}">{{ $payment->status_text }}</span></td>
                    </tr>
                    @if ($payment->description)
                    <tr>
                        <td>@lang('Note')</td>
                        <td>{{ __($payment->description) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td>@lang('Payment Confirmation')</td>
                        <td><a target="_blank" href="{{ storage_url($payment->confirmation_picture) }}"><img src="{{ storage_url($payment->confirmation_picture) }}" style="max-width:100%;max-height:300px;" alt="@lang('Payment Confirmation')"></a></td>
                    </tr>
                </table>
            </div>
        </div>
        {{-- Payment actions if is pending --}}
        @if ($payment->status == $payment::PENDING)
        <div class="text-center">
            <div class="d-inline-block">
                <a href="javascript:;" class="btn btn-success" data-payment-action="confirm-payment" data-confirmation-message="@lang('Are you sure you want to confirm this payment?')">@lang('Confirm Payment')</a>
                <form action="{{route('backend.subscriptions-management.payment_status_action', [$payment->id, 'confirm'])}}" method="POST">@csrf @method('PUT')</form>
            </div>
            <div class="d-inline-block">
                <a href="javascript:;" class="btn btn-danger" data-payment-action="confirm-payment" data-confirmation-message="@lang('Are you sure you want to decline this payment?')">@lang('Decline Payment')</a>
                <form action="{{route('backend.subscriptions-management.payment_status_action', [$payment->id, 'decline'])}}" method="POST">@csrf @method('PUT')</form>
            </div>
        </div>
        @endif
        <hr>

        {{-- Subscriber information --}}
        <div>
            <h3>@lang('Subscriber information'):</h3>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td>#ID</td>
                        <td>{{$user_->id}}</td>
                    </tr>
                    <tr>
                        <td>@lang('Name')</td>
                        <td>{{$user_->name}}</td>
                    </tr>
                    <tr>
                        <td>@lang('Account type')</td>
                        <td>
                            @if ($user_->hasRole('artist'))
                                @lang('Artist account')
                            @elseif($user->hasRole('store'))
                                @lang('Store account')
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>@lang('Avatar')</td>
                        <td>
                            <div class="avatar-50">
                                <img src="{{$user_->avatar_url}}" alt="{{$user_->name}}" class="avatar-50">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>@lang('Email')</td>
                        <td><a href="mailto:{{$user_->email}}">{{$user_->email}}</a></td>
                    </tr>
                    @if ($user_->phone)
                    <tr>
                        <td>@lang('Phone')</td>
                        <td><a href="tel:{{$user_->phone}}">{{$user_->phone}}</a></td>
                    </tr>
                    @endif
                    <tr>
                        <td>@lang('Gender')</td>
                        <td>@lang(Str::ucfirst($user_->gender))</td>
                    </tr>
                    @if ($user_->nationality)
                    <tr>
                        <td>@lang('Nationality')</td>
                        <td>@lang($user_->nationality)</td>
                    </tr>
                    @endif
                    @if ($user_->country)
                    <tr>
                        <td>@lang('Country')</td>
                        <td>@lang(country($user_->country)->getName())</td>
                    </tr>
                    @endif
                    <tr>
                        <td>@lang('Registration date')</td>
                        <td>{{ date_formated($user_->created_at) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="module">
$(function(){
    $(document).on('click', '[data-payment-action]', function(){
        if(confirm($(this).data('confirmation-message'))){
            $(this).parent().find('form').submit();
        }
    })
})
</script>
@endpush
@push('styles')
<style>
    tr td:first-child{
        font-weight: 600;
    }
</style>
@endpush
