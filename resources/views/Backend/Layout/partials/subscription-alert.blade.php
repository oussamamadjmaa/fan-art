
@if (session('resent'))
<div class="alert alert-success" role="alert">
    {{ __('A fresh verification link has been sent to your email address.') }}
</div>
@endif
<div class="mxw-1600 px-3">
    <div class="alert alert-warning">
        {{ __('Please check your email for a verification link.') }}
        {{ __('If you did not receive the email') }},
        <form class="d-inline" action="{{ route('verification.resend') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
        </form>
    </div>
</div>

@role('artist|store')
    <div class="px-3 mxw-1600">
        @if (auth()->user()->activeSubscription)
        @if (auth()->user()->activeSubscription->is_free())
            <div class="alert alert-warning">
                <i class="fas fa-clock"></i> @lang('backend.subscription_days_left', [
                    'days' => auth()->user()->activeSubscription->days_left(),
                    'plan_name' => auth()->user()->activeSubscription->plan->name,
                ]) <a href="{{route('backend.subscription.index')}}">@lang('Upgrade')</a>
            </div>
        @endif
    @else
        <div class="alert alert-danger">
            <i class="fas fa-clock"></i> @lang('backend.subscription_expired') <a href="{{route('backend.subscription.index')}}">@lang('Renew subscription')</a>
        </div>
    @endif
    </div>
@endrole



