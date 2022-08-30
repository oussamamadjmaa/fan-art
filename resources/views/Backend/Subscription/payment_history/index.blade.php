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
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('Payment Method')</th>
                            <th>@lang('Plan name')</th>
                            <th>@lang('Duration')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Payment Status')</th>
                            <th>@lang('Date')</th>
                            <th>@lang('Note')</th>
                        </tr>
                    </thead>
                    <tbody id="page-data-list">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
