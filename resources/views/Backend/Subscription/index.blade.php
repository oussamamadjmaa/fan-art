@extends('Backend.Layout.master', ['title' => __('Subscription')])
@section('content')
<section>
    <div class="card">
        <div class="card-body">
            <h3 class="text-primary">@lang('Current plan'):</h3>
            <ul>
                <li><b>@lang('Plan name')</b>: {{ $subscription->plan->name }}</li>
                <li><b>@lang('Plan status')</b>: {{ $subscription->status_text }}</li>
                @if (now()->gt($subscription->expires_at))
                <li><b>@lang('Expired at')</b>: {{ date_formated($subscription->expires_at) }} ({{$subscription->expires_at->diffForHumans()}})</li>
                @else
                <li><b>@lang('Expire at')</b>: {{ date_formated($subscription->expires_at) }} ({{$subscription->expires_at->diffForHumans()}})</li>
                @endif
            </ul>
        </div>
    </div>
</section>
@endsection
