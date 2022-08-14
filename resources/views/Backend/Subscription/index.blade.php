@extends('Backend.Layout.master', ['title' => __('Subscription')])
@section('content')
<section>
    <div class="card">
        <div class="card-body">
            <div>
                <h3 class="text-primary">@lang('Current plan'):</h3>
                <ul>
                    <li><b>@lang('Plan name')</b>: {{ $subscription->plan->name }}</li>
                    <li><b>@lang('Plan status')</b>: {{ $subscription->status_text }}</li>
                    @if (now()->gt($subscription->expires_at))
                    <li><b>@lang('Expired at')</b>: {{ date_formated($subscription->expires_at) }} ({{$subscription->expires_at->diffForHumans()}})</li>
                    @else
                    <li><b>@lang('Expire at')</b>: {{ date_formated($subscription->expires_at) }}</li>
                    @endif
                </ul>
                @if (!$subscription->is_free())
                    <button class="btn btn-primary">@lang('Renew subscription')</button>
                @endif
            </div>
            @if ($higher_plans)
            <hr>
            <div>
                <h3 class="text-primary">@lang('Upgrade plan'):</h3>
                <div class="row">
                    @foreach ($higher_plans as $plan_)
                    <div class="col-md-6">
                        <h5>{{$plan_->name}}</h5>
                        <form action="javascript:;" method="post">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{$plan_->id}}">
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="duration" id="duration" value="yearly" checked>
                              <label class="form-check-label" for="duration">
                                @lang('Yearly') {{price_format($plan_->price)}} @lang('SAR')/@lang('Year')
                              </label>
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
                            <x-form.input type="file" name="confirmation_picture" id="confirmation_picture" label="Upload bank transfer receipt" inputAttributes="onchange=_s.uploadImage(this) data-path=confirmation_pictures" :value="old('confirmation_picture')" />

                            <button class="btn btn-primary">@lang('Subscribe')</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
@push('styles')
    <style>
        [for=confirmation_picture] {
            margin-top: 1rem!important;
        }
    </style>
@endpush
