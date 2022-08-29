@extends('Backend.Layout.master', ['title' => __('Artwork Messages')])
@section('content')
<div>
    <x-buttons.icon-button :text="__('Back')" icon="fa fa-arrow-right" onclick="window.location.href='{{route('backend.artworks.index')}}'" />
</div>
<div class="card mt-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex mb-3 mb-md-0">
            <div class="d-flex flex-wrap">
                <h5 class="mb-0"><i class="bi bi-envelope"></i> @lang('Artwork Messages')</h5> <span class="text-secondary ms-2">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="artwork-show p-2 border-bottom">
            <div class="d-flex">
                <div class="me-2">
                    <div class="pic-w150">
                        <img src="{{ storage_url($artwork->image) }}" alt="" class="pic-w150">
                    </div>
                </div>
                <div>
                    <h6>{{ $artwork->title }}</h6>
                    <small class="mb-0 d-block text-secondary">{{ $artwork->dimensions }}</small>
                    <small class="mb-0">{{ $artwork->location }}</small>
                </div>
            </div>
        </div>
        <div id="page-data-list"></div>
    </div>
</div>
@endsection
