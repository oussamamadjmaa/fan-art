@php
$meta = $meta ?? NULL;
$title =   $meta->title ?? $title ?? '';
$title = $title ? $title . ' | '. config('app.name') : config('app.name');

$dir = config('app.direction');
$auth_ = Auth::user();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $dir }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="index, archive">

    <title>{{ $title }}</title>

    <meta name="title"  content="{{$title}}">
    <meta name="description"  content="{{$meta?->description ?? config('app.seo.description')}}">
    <meta name="keywords"  content="{{$meta?->keywords ?? config('app.seo.keywords')}}">

    <!--  Essential META Tags -->

    <meta property="og:title" content="{{$title}}">
    <meta property="og:description" content="{{$meta?->description ?? config('app.seo.description')}}">
    <meta property="og:image" content="{{$meta?->image ?? asset('assets/images/art-logo.png')}}">
    <meta property="og:url" content="{{request()->fullUrl()}}">
    <meta name="twitter:card" content="summary_large_image">

    <!--  Non-Essential, But Recommended -->
    <meta name="og:site_name" content="{{config('app.name')}}">

    {{-- <!--  Non-Essential, But Required for Analytics -->
    <meta property="fb:app_id" content="your_app_id" />
    <meta name="twitter:site" content="@website-username"> --}}

    <!-- CSS FONTS -->
    {{-- <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100;200;300;400&display=swap" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;700&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@400;700&display=swap" rel="stylesheet">

    <!-- CSS VENDORS -->
    <link rel="stylesheet" href="{{ asset('vendors/font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link href="{{ asset("vendors/bootstrap/css/bootstrap.$dir.min.css") }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/jquery/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/owl-carousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/owl-carousel/assets/owl.theme.default.min.css') }}">

    <!-- Styles -->
    @vite(['resources/frontend-assets/sass/app.scss'])

    @stack('styles')
</head>

<body class="{{ $dir }}">
    <script>
        GLOBAL = {!! app_json_data() !!};
    </script>

    @include('Frontend.Layout.partials.navbar')

    <div class="app-container" id="app">
        <div class="app-preloader">
            <div class="app-preloader-img">
                <img src="{{ asset('assets/images/art-logo.png') }}" alt="{{config('app.name')}}" height="107">
            </div>
        </div>
        <div class="app-content">
            @yield('content')
        </div>
    </div>

    {{-- Register modal --}}
    @include('Frontend.Layout.partials.register-modal')

    <!-- Vars & Consts -->
    <script>
        let lang = {!! translation_json() !!};
    </script>

    <!-- App Scripts -->
    {{-- <script src="{{ asset('panel-assets/js/app.js') }}"></script> --}}

    @vite(['resources/frontend-assets/js/app.js'])

    <script src="{{ asset('vendors/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}" defer></script>

    <!-- Vendors -->
    <script src="{{ asset('vendors/select2/select2.min.js') }}" defer></script>
    <script src="{{ asset('vendors/jquery/js/jquery-ui.js') }}" defer></script>
    <script src="{{ asset('vendors/owl-carousel/owl.carousel.js') }}" defer></script>

    <!-- Page Scripts --> @stack('scripts')

    @include('Frontend.Layout.partials.sweetalert2')

</body>

</html>
