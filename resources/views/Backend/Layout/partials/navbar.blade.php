<navbar class="mnav">
    <div class="mnav-header">
        <div class="mnav__phone-bars">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="mnav__logo">
            <a href="{{route('backend.dashboard')}}">
                <img src="{{ asset('panel-assets/images/art-logo.png') }}" alt="{{ config('app.name') }}">
            </a>
        </div>
        <div class="d-flex align-items-center justify-content-end d-pc-none h-100">
            @include('Backend.Layout.partials.notifications')
            @include('Backend.Layout.partials.language-menu', ['is_phone' => true])
            @include('Backend.Layout.partials.user-dropdown-menu', ['is_phone' => true])
        </div>
    </div>
    <div class="mnav-content">
        {{-- <div class="mnav__right-content"></div> --}}
        <div class="mnav__left-content">
            @include('Backend.Layout.partials.notifications')
            @include('Backend.Layout.partials.language-menu')
            @include('Backend.Layout.partials.user-dropdown-menu')
        </div>
    </div>

    <form action="/logout" style="display:none;" id="logoutForm" method="POST">@csrf</form>
</navbar>
