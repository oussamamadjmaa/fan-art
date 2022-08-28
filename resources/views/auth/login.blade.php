@extends('Frontend.Layout.app')

@section('content')
    <div class="auth auth-container container my-5 pt-3">
        <div class="auth-form mt-5">
            <div class="auth-form-box col-lg-5 col-md-10 mx-auto">
                <div id="loginForm">
                    <div class="heading text-center">
                        <h1>@lang('Hello')</h1>
                        <p>@lang('Sign in to your account')</p>
                    </div>

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="inputs">
                            <x-auth.form.input type="email" class="{{$errors->has('email') ? 'is-invalid' : ''}}"
                                        name="email" id="email" placeholder="{{ __('Email Address') }}"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus />
                            <x-auth.form.input type="password" name="password" id="password"
                                        placeholder="{{ __('Password') }}" autocomplete="current-password" />
                            <div class="mb-3">
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="forgot-password">@lang('Forgot Your Password?')</a>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="auth-btn">
                                @lang('Login')
                                <i class="fa fa-arrow-left"></i>
                            </button>
                        </div>
                        <div class="new-account text-center mt-5">
                            @lang("Don't have an account?") <a href="javascript:;" data-bs-toggle="modal"
                                data-bs-target="#registerationLinks"> @lang('Register now')</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
