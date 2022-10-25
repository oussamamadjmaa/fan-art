@extends('Backend.Layout.master', ['title' => __('Website Settings')])
@section('content')
@php
    $settings_list = [
        'general' => [
            'title' => __('General Settings'),
            'icon' => 'bi bi-gear',
        ],'bank' => [
            'title' => __('Bank Settings'),
            'icon' => 'bi bi-bank',
        ],'smtp' => [
            'title' => __('Smtp Settings'),
            'icon' => 'bi bi-envelope',
        ],'ads' => [
            'title' => __('Advertisements'),
            'icon' => 'bi bi-badge-ad',
        ],'whos_us' => [
            'title' => __('من نحن'),
            'icon' => 'bi bi-question-diamond',
        ]
    ]
@endphp
    <section>
        <div class="card">
            <div class="card-body">
                <div class="row website-settings-list">

                    @foreach ($settings_list as $setting_tab => $setting_data)
                    <div class="col-lg-3 col-md-4 col-sm-6 my-1">
                        <a class="website-setting-item" href="{{ route('backend.website-settings.tab', $setting_tab) }}">
                            <div class="icon">
                                <h1><i class="{{$setting_data['icon']}}"></i></h1>
                                <h5>{{$setting_data['title']}}</h5>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
@push('styles')
<style>
    .website-setting-item {
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
