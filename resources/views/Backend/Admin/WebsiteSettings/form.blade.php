@php
    $title = __(Str::ucfirst($tab).' Settings');
@endphp
@extends('Backend.Layout.master', ['title' => $title])
@section('content')
    <section>
        <div class="card">
            <div class="card-header py-3">
                <h5 class="mb-0">{{$title}}</h5>
            </div>
            <div class="card-body">
                <div class="col-lg-6 col-md-8 col-12">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>
                    @endif
                     <form action="{{route('backend.website-settings.save', $tab)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            @foreach ($form_fields as $field)
                                <x-form.input  :label="$field['title']" :name="$field['name']" :value="$field['value']" />
                            @endforeach
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary"><span>@lang('Save')</span></button>
                            <a href="{{route('backend.website-settings.index')}}" class="btn btn-secondary">@lang('Back')</a>
                            {{-- <button type="button" class="btn btn-secondary">@lang('Reset Defaults')</button> --}}
                        </div>
                     </form>
                </div>
            </div>
        </div>
    </section>
@endsection
