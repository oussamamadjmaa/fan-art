@extends('Frontend.Layout.app')

@section('content')
    <div class="auth auth-container container my-5 pt-3">
        <div class="auth-form mt-5">
            <div class="auth-form-box col-xl-8 col-lg-10 col-md-12 mx-auto">
                <div>
                    <div class="heading text-center">
                        <h2>@lang('Artist Registration') <i class="fas fa-palette"></i></h2>
                        <p>@lang('Help us get your basic information in the first step')</p>
                    </div>

                    <form action="{{ route('register', $role) }}" method="POST">
                        @csrf
                        <div class="inputs">
                            <div class="row">
                                <div class="col-md-6">
                                    <x-auth.form.input type="text" class="{{$errors->has('name') ? 'is-invalid' : ''}}"
                                        name="name" id="name" placeholder="{{ __('Triple name') }}"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus />
                                </div>
                                <div class="col-md-6">
                                    <x-auth.form.input type="select" name="nationality" id="nationality">
                                        <option value="">@lang('Select Nationality')...</option>
                                        @foreach (__('nationalities') as $nationalityEn => $nationalityAr)
                                            <option value="{{$nationalityEn}}" @selected($nationalityEn == old('nationality'))>@lang($nationalityEn)</option>
                                        @endforeach
                                    </x-auth.form.input>
                                </div>
                                <div class="col-md-6">
                                    <x-auth.form.input type="select" name="country" id="country">
                                        <option value="">@lang('Select Country')...</option>
                                        @foreach ($countries as $countryCode => $country)
                                            <option value="{{$countryCode}}" @selected($countryCode == old('country', strtolower($location_data->countryCode)))>@lang(country($countryCode)->getName())</option>
                                        @endforeach
                                    </x-auth.form.input>
                                </div>
                                <div class="col-md-6">
                                    <x-auth.form.input type="select" name="gender" id="gender">
                                        <option value="male" @selected(old('gender') == "male")>@lang('Male')</option>
                                        <option value="female" @selected(old('gender') == "female")>@lang('Female')</option>
                                    </x-auth.form.input>
                                </div>
                                <div class="col-md-6">
                                    <x-auth.form.input type="text" class="{{$errors->has('website') ? 'is-invalid' : ''}}"
                                        name="website" id="website" placeholder="{{ __('Website') }} ({{ __('If exists') }})"
                                        value="{{ old('website') }}" autocomplete="website" />
                                </div>
                                <div class="col-md-6">
                                    <x-auth.form.input type="text" class="{{$errors->has('username') ? 'is-invalid' : ''}}"
                                        name="username" id="username" placeholder="{{ __('Username') }}"
                                        value="{{ old('username') }}" required autocomplete="username" />
                                </div>
                                <div class="col-md-6">
                                    <x-auth.form.input type="email" class="{{$errors->has('email') ? 'is-invalid' : ''}}"
                                        name="email" id="email" placeholder="{{ __('Email Address') }}"
                                        value="{{ old('email') }}" required autocomplete="email" />
                                </div>
                                <div class="col-md-6">
                                    <x-auth.form.input type="text" class="{{$errors->has('phone') ? 'is-invalid' : ''}}"
                                        name="phone" id="phone" placeholder="{{ __('Phone') }}"
                                        value="{{ old('phone') }}" required autocomplete="phone" />
                                </div>
                                <div class="col-md-6">
                                    <x-auth.form.input type="password" class="form-control" name="password" id="password"
                                    placeholder="{{ __('Password') }}" autocomplete="current-password" required />
                                </div>
                                <div class="col-md-6">
                                    <x-auth.form.input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                                    placeholder="{{ __('Confirm Password') }}" autocomplete="new-password" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <p>{{ __('By creating this account you agree to') }} <a href="javascript:;">@lang('Subscription Terms')</a> @lang('and') <a href="javascript:;">@lang('Privacy Policy')</a></p>
                            </div>
                        </div>
                        <div>
                            <button class="auth-btn">
                                @lang('Register')
                                <i class="fa fa-arrow-left"></i>
                            </button>
                        </div>
                        <div class="new-account text-center mt-5">
                            @lang("You already have an account?") <a href="{{route('login')}}" > @lang('Sign in')</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
