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
                                <x-form.input :type="($field['type'])" :label="$field['title']" :name="$field['name']" :value="$field['value']" :inputAttributes="$field['inputAttributes']" />
                            @endforeach
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary"><span>@lang('Save')</span></button>
                            <a href="{{route('backend.website-settings.index')}}" class="btn btn-secondary">@lang('Back')</a>
                        </div>
                     </form>
                     <hr>
                     <form action="{{route('backend.website-settings.save', [$tab, 'reset_defaults'])}}" method="post" id="resetDefaults" data-confirmation="@lang('Are you sure you want to reset default settings?')">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-dark">@lang('Reset Defaults')</button>
                     </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
<script type="module">
    $(function(){
        $(document).on('submit', '#resetDefaults', function(e){
            if(!confirm($(this).data('confirmation'))){
                e.preventDefault();
            }
        });
    })
</script>
@endpush
