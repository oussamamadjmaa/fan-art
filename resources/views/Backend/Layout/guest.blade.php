@php
    $dir = config('app.direction');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{$dir}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? '_' }} - {{ config('app.name') }}</title>

    <!-- CSS VENDORS -->
    <link rel="stylesheet" href="{{ asset('vendors/font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link href="{{ asset("vendors/bootstrap/css/bootstrap.$dir.min.css") }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendors/toastr/toastr.min.css') }}">


    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('panel-assets/css/guest.min.css')}}">
    @stack('styles')
</head>
<body class="{{$dir}}">
    <div id="app">
        <div class="container">
            @yield('content')
        </div>
    </div>

    <!-- App Scripts -->
    <script src="{{ asset('panel-assets/js/guest.js') }}"></script>
    <script>
        $(document).on('submit', 'form', function(){
            $(this).find('.btn-primary').prop('disabled', true);
        });
    </script>
    @stack('scripts')
</body>
</html>
