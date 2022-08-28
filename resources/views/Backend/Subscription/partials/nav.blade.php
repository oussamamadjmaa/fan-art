<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link @if (Route::is('backend.subscription.index')) active @endif" aria-current="page" href="{{route('backend.subscription.index')}}">@lang('Subscription')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::is('backend.subscription.payment_history')) active @endif" href="{{ route('backend.subscription.payment_history') }}">@lang('Payment history')</a>
    </li>
</ul>
