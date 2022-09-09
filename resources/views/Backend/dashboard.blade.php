@extends('Backend.Layout.master')
@section('content')
@role ('artist')
    @include('Backend.Dashboard.artist')
@elserole('store')
    @include('Backend.Dashboard.store')
@endrole
@endsection
@push('scripts')
@role ('artist')
    @vite(['resources/backend-assets/js/pages/artist_dashboard.js'])
@elserole('store')
    @vite(['resources/backend-assets/js/pages/store_dashboard.js'])
@endrole
@endpush
