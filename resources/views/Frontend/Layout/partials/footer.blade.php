<footer id="footer">
    <div class="app-footer">
        <div class="container">
            <div class="row mx-0 pt-4">
                <div class="col-lg-4 col-md-3 mb-5">
                    <a class="footer-logo" href="{{route('frontend.home')}}">
                        <img src="{{ storage_url(config('app.logo')) }}" alt="{{ config("app.name") }}">
                    </a>
                    <p class="mt-3 text-white px-2">{{config('app.seo.description')}}</p>
                </div>
                <div class="col-lg-4 col-md-3 mb-4">
                    <a href="https://maroof.sa/269969" title="معروف" target="_blank">
                        <img src="{{ asset('assets/images/maroof-logo.png') }}" alt="شعار معروف ">
                    </a>
                    <h5 class="maarof-number mt-3">رقم معروف: 269969</h5>
                </div>
                <div class="col-lg-2 col-md-3 mb-4">
                    <h4 class="text-white mb-3">روابط</h4>
                    <ul class="footer-footer-links py-1">
                        <li><a href="{{route('frontend.artists.index')}}">@lang('Artists')</a></li>
                        <li><a href="{{route('frontend.artworks.index')}}">@lang('Paintings and artwork')</a></li>
                        <li><a href="{{route('frontend.exhibitions.index')}}">@lang('Exhibitions and meetings')</a></li>
                        <li><a href="{{route('frontend.stores.index')}}">@lang('Stores')</a></li>
                        <li><a href="{{ url('p/contact-us') }}">@lang('Contact us')</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-3 mb-4">
                    <ul class="footer-footer-links py-1">
                        @foreach (footer_pages() as $footer_page)
                            <li><a href="{{route('frontend.page', $footer_page->slug)}}">{{$footer_page->title}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <hr class="my-0 py-0">
            <div class="py-2">
                <p class="mb-0 py-1 text-center text-white">© {{config('app.name')}} {{date('Y')}}</p>
            </div>
        </div>
    </div>
</footer>
