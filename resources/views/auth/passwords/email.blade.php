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
                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="inputs">
                        <x-auth.form.input type="email" class="{{$errors->has('email') ? 'is-invalid' : ''}}"
                            name="email" id="email" placeholder="{{ __('Email Address') }}"
                            value="{{ old('email') }}" required autocomplete="email" autofocus />
                    </div>
                    <div>
                        <button class="auth-btn">
                            @lang('Send Password Reset Link')
                            <i class="fa fa-arrow-left"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
