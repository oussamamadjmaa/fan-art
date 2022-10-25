@extends('Backend.Layout.master', ['title' => __('Contact artists')])
@section('content')
<div class="card">


    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{session('error')}}
            </div>
        @endif

        <form action="{{route('backend.contact_artists.send')}}" method="POST" id="sendMessageForm">
            @csrf

            <x-form.input name="subject" inputAttributes="required" label="Subject" />

            <x-form.select2 name="artist_type" label="Receipt Email Addresses" required="required">
                <option value="all" @selected(old('artist_type') == "all")>@lang('All')</option>
                <option value="artist" @selected(old('artist_type') == "artist")>@lang('artist')</option>
                <option value="calligrapher" @selected(old('artist_type') == "calligrapher")>@lang('calligrapher')</option>
            </x-form.select2>

            <div class="mb-3">
                <label for="content" class="form-label">@lang('Message')</label>
                <textarea class="form-control mailMessageTextarea" name="content" id="content" rows="6" required>{{old('content')}}</textarea>
                <div class="invalid-feedback"></div>
            </div>

            <div class="border-top">
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary" id="sendMessage">
                        <span>@lang('Send message')</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script type="module">
    _s.makeTinymce(".mailMessageTextarea");

    $(document).on('click', "#sendMessage", function(){ tinyMCE.triggerSave(); });
</script>
@endpush
