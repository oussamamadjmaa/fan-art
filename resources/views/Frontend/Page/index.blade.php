@extends('Frontend.Layout.app')
@section('content')
<div class="bg-white">
    <div class="container py-4">
        <h1 class="mb-2">{{$page->title}}</h1>
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('frontend.home')}}">@lang('Home')</a></li>
                <li class="breadcrumb-item active"><a href="javascript:;">{{$page->title}}</a></li>
            </ol>
        </nav>

        <div>
            {!! nl2br($page->content) !!}
        </div>

    </div>
</div>
@endsection
