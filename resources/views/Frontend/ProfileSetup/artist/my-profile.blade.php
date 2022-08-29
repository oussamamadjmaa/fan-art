@extends('Frontend.Layout.app')
@section('content')
    <div class="auth auth-container container my-5 pt-3">
        <div class="auth-form mt-5">
            <div class="auth-form-box col-md-10 mx-auto">
                <div>
                    <div class="heading text-center">
                        <h2>@lang('Welcome') , {{ auth()->user()->name }}</h2>
                        <p>@lang("Let's setup your profile")</p>
                    </div>
                    <div class="mb-3 custom-file-input text-center">
                        <label for="avatar" class="form-label">
                          <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" id="avatarPlaceholder">
                          <i class="fa fa-camera"></i>
                        </label>
                        <input type="file" class="@error('avatar') is-invalid @enderror" image-placeholder="#avatarPlaceholder" id="avatar">
                        @error('avatar')
                              <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <form action="{{ route('frontend.setup_profile.save', 'my-profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="inputs">
                            <div class="mb-3">
                                <label for="bio" class="form-label">@lang('Bio')</label>
                                <textarea class="form-control @error('bio') is-invalid @enderror" name="bio" id="bio" rows="5" placeholder="@lang('Bio')">{{ old('bio', auth()->user()->profile?->bio) }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                              <label for="cv" class="form-label">@lang('CV') (PDF)  <sup>(@lang('Optional'))</sup></label>
                              <input type="file" class="form-control @error('cv') is-invalid @enderror" name="cv" id="cv" accept="application/pdf">
                                @error('cv')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <h3 class="mt-5">@lang('Social Media') <small><sup>(@lang('Optional'))</sup></small></h3>
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
                        <div>
                            <button class="auth-btn me-auto">
                                @lang('Save and continue')
                                <i class="fa fa-arrow-left"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<link rel="stylesheet" href="{{ asset('vendors/cropper/cropper.min.css') }}">
<script src="{{ asset('vendors/cropper/cropper.min.js') }}" defer></script>
@endpush
