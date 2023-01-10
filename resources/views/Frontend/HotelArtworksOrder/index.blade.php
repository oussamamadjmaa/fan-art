@extends('Frontend.Layout.app')
@section('content')
<section class="bg-white py-4">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">@lang('Home')</a></li>
                <li class="breadcrumb-item active"><a href="javascript:;">@lang('طلب لوحات فنية خاصة بالفنادق')</a></li>
            </ol>
        </nav>

        <div class="col-lg-8 col-md-10 mx-auto">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form data-action="{{route('frontend.artworks.order.hotels')}}" method="POST">
                @csrf
                <div class="row">
                    <x-form.input class="col-md-6" type="facility_name" name="facility_name" label="Facility name" />
                    <x-form.input class="col-md-6" inputAttributes="required" type="responsible_person" name="responsible_person" label="Responsible person" />
                    <x-form.input type="city" name="city" inputAttributes="required" label="City" />
                </div>


                <div class="row">
                    <x-form.input class="col-md-6" type="email" name="email" inputAttributes="required" label="Email" />
                    <x-form.input class="col-md-6" name="phone" label="Phone" />
                </div>

                <div class="row">
                    <x-form.input type="number" name="quantity" inputAttributes="required" label="عدد اللوحات الفنية " />
                    <x-form.input name="sizes" inputAttributes="required" label="مقاسات اللوحات " />
                </div>

                <x-form.input type="textarea" name="idea" label="طلب فكرة خاصة" />


                <button class="primary-btn pt-2 pb-1 px-3" id="send_btn">
                    @lang('Send Order')
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
