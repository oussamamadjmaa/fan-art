@extends('Backend.Layout.master', ['title' => __('Subscriptions Management')])
@section('content')

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-4">
                <a class="heading_-item" href="{{ route('backend.subscriptions-management.index', 'pending') }}">
                    <div class="icon">
                        <h1><i class="bi bi-patch-question-fill"></i></h1>
                        <h6>@lang('Pending') ({{$payments_stats['pending']}})</h6>
                    </div>
                </a>
            </div>
            <div class="col-4">
                <a class="heading_-item" href="{{ route('backend.subscriptions-management.index', 'confirmed') }}">
                    <div class="icon">
                        <h1><i class="bi bi-patch-check-fill"></i></h1>
                        <h6>@lang('Confirmed') ({{$payments_stats['confirmed']}})</h6>
                    </div>
                </a>
            </div>
            <div class="col-4">
                <a class="heading_-item" href="{{ route('backend.subscriptions-management.index', 'declined') }}">
                    <div class="icon">
                        <h1><i class="bi bi-patch-minus-fill"></i></h1>
                        <h6>@lang('Declined') ({{$payments_stats['declined']}})</h6>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body pb-0">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Payment Method')</th>
                        <th>@lang('Plan name')</th>
                        <th>@lang('Duration')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Payment Status')</th>
                        <th>@lang('Note')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>
                <tbody id="page-data-list">
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('styles')
<style>
    .heading_-item {
        background-color: #16263f;
        text-align: center;
        padding: 1rem;
        border-radius: 30px;
        color: #fff;
        display: block;
        cursor: pointer;
        transition: all .21s ease-in-out;
    }
</style>
@endpush
