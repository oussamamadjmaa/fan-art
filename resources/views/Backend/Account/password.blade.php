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
                 <form action="{{route('backend.account.save', 'password')}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row inputs">
                        <x-auth.form.input type="password" :placeholder="__('Current Password')" name="current_password" required />
                        <x-auth.form.input type="password" :placeholder="__('New Password')" name="new_password" required />
                        <x-auth.form.input type="password" :placeholder="__('Confirm Password')" name="new_password_confirmation" required />
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary"><span>@lang('Change Password')</span></button>
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
