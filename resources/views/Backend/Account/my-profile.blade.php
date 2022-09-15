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
                 <form action="{{route('backend.account.save', 'profile')}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row inputs">
                        @php
                            $user = auth()->user();
                        @endphp
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
                        <x-auth.form.input  :placeholder="__('Username')" name="username" :value="old('username', $user->username)" required />
                        <x-auth.form.input  :placeholder="__('Full name')" name="name" :value="old('name', $user->name)" required />
                        <x-auth.form.input  :placeholder="__('Phone')" name="phone" :value="old('phone', $user->phone)" />

                        @role('artist')
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="show_phone" name="show_phone"
                                    @checked($user?->profile?->privacy_settings?->show_phone)>
                                <label class="form-check-label" for="show_phone">
                                    @lang('Show phone on profile')
                                </label>
                            </div>
                        </div>
                        @endrole

                        <x-auth.form.input  :placeholder="__('Email')" name="email" :value="old('email', $user->email)" />
                        @role('artist')
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="show_email" name="show_email"
                                    @checked($user?->profile?->privacy_settings?->show_email)>
                                <label class="form-check-label" for="show_email">
                                    @lang('Show email on profile')
                                </label>
                            </div>
                        </div>
                        @endrole

                        <x-auth.form.input type="select" name="gender" :placeholder="__('Gender')" required>
                            <option value="male" @selected(old('gender', $user->gender) == "male")>@lang('Male')</option>
                            <option value="female" @selected(old('gender', $user->gender) == "female")>@lang('Female')</option>
                        </x-auth.form.input>
                        <x-auth.form.input type="select" name="nationality" :placeholder="__('Nationality')" required>
                            <option value="">@lang('Select Nationality')...</option>
                            @foreach (__('nationalities') as $nationalityEn => $nationalityAr)
                                <option value="{{$nationalityEn}}" @selected($nationalityEn == old('nationality', $user->nationality))>@lang($nationalityEn)</option>
                            @endforeach
                        </x-auth.form.input>
                        <x-auth.form.input type="select" name="country" :placeholder="__('Country')" required>
                            <option value="">@lang('Select Country')...</option>
                            @foreach ($countries as $countryCode => $country)
                                <option value="{{$countryCode}}" @selected($countryCode == old('country', strtolower($user->country)))>@lang(country($countryCode)->getName())</option>
                            @endforeach
                        </x-auth.form.input>
                        @role('store')
                        <x-auth.form.input type="textarea" class="{{$errors->has('address') ? 'is-invalid' : ''}}"
                            name="address" id="address" :placeholder="__('Store address')"
                            value="{{ old('address', $user->address) }}" required rows="2" autocomplete="address" />
                        @endrole

                        @role('store|artist')
                        <x-auth.form.input dir="ltr"  :placeholder="__('Website')" name="website" :value="old('website', $user->website)" />
                        @endrole
                        <x-auth.form.input type="password" :placeholder="__('Current Password')" name="current_password" required />
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
<link rel="stylesheet" href="{{ asset('vendors/cropper/cropper.min.css') }}">
<script src="{{ asset('vendors/cropper/cropper.min.js') }}" defer></script>
@endpush
