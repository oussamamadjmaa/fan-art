@props([
    'label' => '',
    'name',
    "type" => "text",
    "id",
    "value" => "",
])
@php
    $label = (!$label && isset($name)) ? trans_('validation.attributes.'.$name) : trans_('validation.attributes.'.$label);
    $id = $id ?? $name ?? '';
@endphp
<div class="mb-3">
    <label for="{{$id}}" class="form-label">{{$label}}</label>
    <select class="form-control"
            @isset($name) name="{{$name}}" @endisset
            id="{{$id}}"
            {{$attributes}} >
    {{ $slot }}
    </select>
    <div class="invalid-feedback"></div>
</div>
