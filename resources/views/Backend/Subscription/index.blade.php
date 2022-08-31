@extends('Backend.Layout.master', ['title' => __('Subscription')])
@section('content')
@php
    $pending_payments_count = auth()->user()->payments()->pending()->count();
@endphp
<section>
    <div class="card">
        @include('Backend.Subscription.partials.nav')
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
                @if (!$subscription->is_free() && !$pending_payments_count)
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#renewSubscription">@lang('Renew subscription')</button>

                    <!-- Modal -->
                    <div class="modal fade" id="renewSubscription" tabindex="-1" role="dialog" aria-labelledby="reneeewSubscribtionTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">@lang('Renew subscription')</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @php
                                        $current_subscription = auth()->user()->subscription;
                                        $current_subscription_plan = $current_subscription->plan;
                                    @endphp
                                    <h5>{{$current_subscription_plan->name}}</h5>
                                    <form action="{{route('backend.subscription.renew_plan')}}" method="post" id="renewSubscriptionForm">
                                        @csrf
                                        <div class="form-check">
                                        <input class="form-check-input" type="radio" name="duration" id="duration" value="yearly" checked>
                                        <label class="form-check-label" for="duration">
                                            @lang('Yearly') {{price_format($current_subscription_plan->price)}} @lang('SAR')/@lang('Year')
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
                                        <x-form.input type="file" name="bank_transfer_receipt" id="bank_transfer_receipt" label="Upload bank transfer receipt" inputAttributes="onchange=_s.uploadImage(this) data-path=confirmation_pictures" :value="old('bank_transfer_receipt')" />

                                        <div class="text-end">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                                            <button type="submit" class="btn btn-primary" id="renewPlan">@lang('Renew subscription')</button>
                                        </div>
                                    </form>
                                </div>
                                {{-- <div class="modal-footer">

                                    <button type="button" class="btn btn-primary">Save</button>
                                </div> --}}
                            </div>
                        </div>
                    </div>

                @endif
            </div>
            @if ($higher_plans->count() && !$pending_payments_count)
            <hr>
            <div>
                <h3 class="text-primary">@lang('Upgrade plan'):</h3>
                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="row">
                    @foreach ($higher_plans as $plan_)
                    <div class="col-md-6">
                        <h5>{{$plan_->name}}</h5>
                        <form action="{{route('backend.subscription.upgrade_plan')}}" method="post">
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
                            <x-form.input type="file" name="bank_transfer_receipt" id="bank_transfer_receipt" label="Upload bank transfer receipt" inputAttributes="onchange=_s.uploadImage(this) data-path=confirmation_pictures" :value="old('bank_transfer_receipt')" />

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
@push('scripts')
<script type="module">
$(function(){
    $(document).on('submit', '#renewSubscriptionForm', function(e){
        e.preventDefault();
        let formData = $(this).serialize();
        let actionUrl = $(this).attr('action');
        $(this).find('button').prop('disabled', true);
        $.ajax({
            method:"POST",
            url:actionUrl,
            data:formData,
            dataType:"JSON"
        }).done((res) => {
           toastr.success(res.message);
           setTimeout(() => {
            window.location.href = res.redirect_to;
           }, 2000);
        }).fail((res) => {
            $(this).find('button').prop('disabled', false);
            toastr.error(res.responseJSON.message || res.statusText);
        })
    })
})
</script>

@endpush
@push('styles')
    <style>
        [for=confirmation_picture] {
            margin-top: 1rem!important;
        }
    </style>
@endpush
