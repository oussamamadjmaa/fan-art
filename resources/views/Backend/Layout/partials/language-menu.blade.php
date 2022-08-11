{{-- @php
    $id = isset($is_phone) ? "langDropdownMenuPhone" : "langDropdownMenu";
@endphp
<div class="dropdown open">
    <a @class(['btn', 'dropdown-toggle' => !isset($is_phone)]) type="button" id="{{$id}}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i @class(['bi bi-translate', 'text-white' => isset($is_phone)])></i>
    </a>
    <div class="dropdown-menu" aria-labelledby="{{$id}}">
        <a class="dropdown-item" href="{{route('lang', 'ar')}}" hreflang="{{route('lang', 'ar')}}">العربية</a>
        <a class="dropdown-item" href="{{route('lang', 'en')}}" hreflang="{{route('lang', 'en')}}">English</a>
    </div>
</div> --}}
