@extends('Frontend.Layout.app')

@section('content')
<div class="auth auth-container container my-5 pt-3">
    <div class="auth-form mt-5">
        <div class="auth-form-box col-md-5 mx-auto">
            <div id="loginForm">
                <div class="heading text-center">
                    <h3>@lang('Verify Your Email Address')</h3>
                </div>
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif
                {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                <form class="d-inline" action="{{ route('verification.resend') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
