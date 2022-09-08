@extends('Backend.Layout.master')
@section('content')
@role ('artist')
    @include('Backend.Dashboard.artist')
@endrole
@endsection
@push('scripts')
@role ('artist')
    @vite(['resources/backend-assets/js/pages/artist_dashboard.js'])
@endrole
@endpush
