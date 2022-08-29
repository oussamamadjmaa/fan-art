<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link @if (Route::is('backend.account.profile')) active @endif" aria-current="page" href="{{route('backend.account.profile')}}">@lang('Profile')</a>
    </li>
    @role('artist')
    <li class="nav-item">
        <a class="nav-link @if (Route::is('backend.account.artist_profile')) active @endif" aria-current="page" href="{{route('backend.account.artist_profile')}}">@lang('Artist Profile')</a>
    </li>
    @endrole
    <li class="nav-item">
        <a class="nav-link @if (Route::is('backend.account.password')) active @endif" href="{{ route('backend.account.password') }}">@lang('Password')</a>
    </li>
</ul>
