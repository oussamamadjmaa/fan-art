@extends('Backend.Layout.master')
@section('content')

<div class="card mt-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex mb-3 mb-md-0">
            <div class="d-flex flex-wrap">
                <h5 class="mb-0"><i class="bi bi-bell"></i> @lang('Notifications')</h5> <span class="text-secondary ms-2">
            </div>
        </div>
        <div class="actions flex-grow">
            @if ($unread_count > 0)
            <a class="btn btn-primary" href="{{route('backend.notifications.mark-all-as-read')}}">
               @lang('Mark all as read')
            </a>
            @endif
        </div>
    </div>
    <div class="card-body p-0">
        <div id="page-data-list"></div>
    </div>
</div>
@endsection
@push('styles')
<style>
    .pagination{
        padding: 1rem 0;
        justify-content: center;
    }
</style>
@endpush
