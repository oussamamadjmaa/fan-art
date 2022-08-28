@extends('Backend.Layout.master', ['title' => __('Payment history')])
@section('content')
    <div class="card">
        @include('Backend.Subscription.partials.nav')
        <div class="card-body pb-0">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div id="page-data-list"></div>
        </div>
    </div>
@endsection
