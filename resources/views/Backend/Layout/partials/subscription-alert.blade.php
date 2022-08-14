@role('artist|store')
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
@endrole
