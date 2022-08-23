<div class="_navbar" id="navbar">
    <div class="_navbar-container">
        <div class="_navbar-logo">
            <a href="{{route('frontend.home')}}">
                <img src="{{ asset('panel-assets/images/art-logo.png') }}" alt="{{ config("app.name") }}">
            </a>
        </div>
        <div class="_navbar-menus">
            <div class="_navbar-top__menu">
                <ul class="_navbar-social_media">
                    <li><a href="#" class="facebook"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="#" class="instagram"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="#" class="twitter"><i class="fab fa-twitter"></i></a></li>
                </ul>
                <div class="_navbar-auth_buttons">
                    @auth
                    <a href="{{ route('backend.dashboard') }}" class="_auth_btn _login_btn">
                        <i class="fas fa-tachometer-alt"></i>
                        @lang('Dashboard')
                    </a>
                    <a href="#" class="_auth_btn _login_btn" onclick="document.getElementById('logoutForm').submit()">
                        <i class="fas fa-sign-out-alt"></i>
                        @lang('Logout')
                        <form action="{{ route('logout') }}" style="display: none" id="logoutForm" method="post">@csrf</form>
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="_auth_btn _login_btn">
                        <i class="fa fa-user"></i>
                        @lang('Login')
                    </a>
                    <a  href="javascript:;" data-bs-toggle="modal" data-bs-target="#registerationLinks" class="_auth_btn _register_btn">
                        <i class="fa fa-user-plus"></i>
                        @lang('Register')
                    </a>
                    @endguest
                    {{-- <div href="#" class="dropdown_links">
                        <a href="#" class="dropdown_links-btn">@lang('Language')</a>
                        <ul class="dropdown_links_menu">
                            <li><a href="#">Do it</a></li>
                            <li><a href="#">Ababa</a></li>
                        </ul>
                    </div> --}}
                </div>
            </div>
            <div class="_navbar-bottom__menu">
                <ul>
                    <li><a href="{{route('frontend.home')}}">@lang('Home')</a></li>
                    <li><a href="{{route('frontend.artists.index')}}">@lang('Artists')</a></li>
                    <li><a href="{{route('frontend.artworks.index')}}">@lang('Paintings and artwork')</a></li>
                    <li><a href="{{route('frontend.exhibitions.index')}}">@lang('Exhibitions and meetings')</a></li>
                    <li><a href="#">@lang('Stores')</a></li>
                    <li><a href="#">@lang('Artist blog')</a></li>
                    <li><a href="#">@lang('Contact us')</a></li>
                </ul>
            </div>
        </div>

        <div class="_navbar__phone-bars">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>
