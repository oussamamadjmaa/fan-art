@php
    $dir = config('app.direction');
    $auth_ = Auth::user();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{$dir}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex">
    <title>
        @if (isset($meta->title) || isset($title)) {{ $meta->title ?? $title }} | @endif {{ config('app.name') }}
    </title>

    <!-- CSS FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100;200;300;400&display=swap" rel="stylesheet">

    <!-- CSS VENDORS -->
    <link rel="stylesheet" href="{{ asset('vendors/font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link href="{{ asset("vendors/bootstrap/css/bootstrap.$dir.min.css") }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendors/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/jquery/css/jquery-ui.css') }}">

    <!-- Styles -->
    @vite(['resources/backend-assets/sass/app.scss'])

    <link rel="icon" type="image/x-icon" href="{{storage_url(config('app.favicon'))}}">

    @stack('styles')
</head>
<body class="{{$dir}}">
    <script>
        GLOBAL = {!! app_json_data() !!};
    </script>

    @include('Backend.Layout.partials.navbar')

    <div class="page-container">

        @include('Backend.Layout.partials.sidebar')

        <div class="page-content">
            @include('Backend.Layout.partials.subscription-alert')

            @include('Backend.Layout.partials.breadcrumb')

            <div class="position-relative">
                <div class="app-content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Vars & Consts -->
    <script>
        const uploadUrl = "{{ route('backend.upload') }}";
        let lang = {!! translation_json() !!};
    </script>

    <!-- App Scripts -->
    {{-- <script src="{{ asset('panel-assets/js/app.js') }}"></script> --}}

    @vite(['resources/backend-assets/js/app.js'])

    <script src="{{ asset('vendors/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}" defer></script>

    <!-- Vendors -->
    <script src="{{ asset('vendors/select2/select2.min.js') }}" defer></script>
    <script src="{{ asset('vendors/toastr/toastr.min.js') }}" defer></script>
    <script src="{{ asset('vendors/tinymce/tinymce.min.js') }}" defer></script>
    <script src="{{ asset('vendors/jquery/js/jquery-ui.js') }}" defer></script>

    <script type="module">
        document.addEventListener('focusin', (e) => {
            if (e.target.closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
                e.stopImmediatePropagation();
            }
        });
    </script>
    <!-- Page Scripts --> @stack('scripts')

</body>
</html>
