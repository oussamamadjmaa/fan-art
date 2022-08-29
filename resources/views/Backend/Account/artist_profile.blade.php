@extends('Backend.Layout.master', ['title' => __('Profile')])
@section('content')
    <div class="card">
        @include('Backend.Account.partials.nav')
        <div class="card-body pb-0">
            <div class="col-lg-6 col-md-8 col-12 mx-auto pb-5">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{session('success')}}
                    </div>
                @endif
                 <form action="{{route('backend.account.save', 'artist_profile')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="inputs">
                            <x-auth.form.input type="textarea" class="{{$errors->has('bio') ? 'is-invalid' : ''}}"
                                name="bio" id="bio" :placeholder="__('Bio')"
                                value="{{ old('bio', auth()->user()->profile?->bio) }}" required rows="5" autocomplete="bio" />

                            <div class="mb-3">
                              <label for="cv" class="form-label">@lang('CV') (PDF)  <sup>(@lang('Optional'))</sup></label>
                              <input type="file" class="form-control @error('cv') is-invalid @enderror" name="cv" id="cv" accept="application/pdf">
                                @error('cv')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if (isset(auth()->user()?->profile?->docs['cv']))
                                <a href="{{ storage_url(auth()->user()?->profile?->docs['cv']) }}" download="@lang('CV') ({{auth()->user()->name}}) - {{ config('app.name') }}.pdf" class="d-block mt-3"><i class="fa fa-file-pdf"></i> @lang('Download') @lang('CV')</a>
                                @endif
                            </div>

                            <h3 class="mt-4">@lang('Social Media') <small><sup>(@lang('Optional'))</sup></small></h3>
                            <hr>
                            <x-auth.form.input type="text" class="{{$errors->has('facebook') ? 'is-invalid' : ''}}"
                                name="facebook" id="facebook" placeholder="{{ __('Facebook') }}"
                                value="{{ old('facebook', auth()->user()?->profile?->social_media['facebook'] ?? '') }}" />
                            <x-auth.form.input type="text" class="{{$errors->has('instagram') ? 'is-invalid' : ''}}"
                                name="instagram" id="instagram" placeholder="{{ __('Instagram') }}"
                                value="{{ old('instagram', auth()->user()?->profile?->social_media['instagram'] ?? '') }}"/>
                            <x-auth.form.input type="text" class="{{$errors->has('twitter') ? 'is-invalid' : ''}}"
                                name="twitter" id="twitter" placeholder="{{ __('Twitter') }}"
                                value="{{ old('twitter', auth()->user()?->profile?->social_media['twitter'] ?? '') }}" />
                                <x-auth.form.input type="text" class="{{$errors->has('linkedin') ? 'is-invalid' : ''}}"
                                    name="linkedin" id="linkedin" placeholder="{{ __('Linkedin') }}"
                                    value="{{ old('linkedin', auth()->user()?->profile?->social_media['linkedin'] ?? '') }}" />
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary"><span>@lang('Save')</span></button>
                    </div>
                 </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script type="module">
$(function(){
    if($('.is-invalid').length){
        $('html, body').animate({
            scrollTop: (($(".is-invalid").first().offset().top) - 90)
        }, 100);
    }
})
</script>
@endpush
