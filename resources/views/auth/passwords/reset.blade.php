@extends('Frontend.Layout.app')

@section('content')
<div class="auth auth-container container my-5 pt-3">
    <div class="auth-form mt-5">
        <div class="auth-form-box col-md-5 mx-auto">
            <div id="resetpasswordForm">
                <div class="heading text-center">
                    <p>@lang('Reset Password')</p>
                </div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="inputs">
                        <x-auth.form.input type="email" class="{{$errors->has('email') ? 'is-invalid' : ''}}"
                            name="email" id="email" placeholder="{{ __('Email Address') }}"
                            value="{{ $email ?? old('email') }}" required autocomplete="email" readonly />
                        <x-auth.form.input type="password" class="form-control" name="password" id="password"
                                    placeholder="{{ __('Password') }}" autocomplete="current-password" required />
                        <x-auth.form.input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                                    placeholder="{{ __('Confirm Password') }}" autocomplete="new-password" required />
                    </div>
                    <div>
                        <button class="auth-btn">
                            @lang('Reset Password')
                            <i class="fa fa-arrow-left"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
