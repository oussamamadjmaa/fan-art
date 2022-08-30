@props([
    'label' => '',
    'placeholder',
    'name',
    "type" => "text",
    "id",
    "inputAttributes" => "",
    "value" => "",
    "help",
])
@php
    $label = (!$label && isset($name)) ? trans_('validation.attributes.'.$name) : trans_('validation.attributes.'.$label);
    $id = $id ?? $name ?? '';
    $value = old($name ?? '', $value);
@endphp

@if($type == "textarea")
<div class="mb-3">
    <label for="{{$id}}" class="form-label">{{$label}}</label>
    <textarea
        @class(['form-control', 'is-invalid' => $errors->has($name ?? '')])
        @isset($name) name="{{$name}}" @endisset
        id="{{$id}}"
        placeholder="{{$placeholder ?? $label}}"
        {{$inputAttributes}}
    >@if($value) {{$value}} @endif</textarea>
    <div class="invalid-feedback">
        @error($name ?? '')
            {{$message}}
        @enderror
    </div>
  </div>
@elseif ($type == "file")
<div {{ $attributes->class('mb-3') }}>
    <label class="form-label file-label" for="{{$id}}">
        <div>
            {{$label}}
            <input type="file"
            class="form-control-file form-control" id="{{$id}}" placeholder="{{$placeholder ?? $label}}" {{$inputAttributes}}>
            <div class="input_image_showcase image_showcase_{{$id}}">
                @if ($value)
                    <img src="{{ filter_var($value, FILTER_VALIDATE_URL) ? $value : asset('storage/'.$value) }}">
                @endif
            </div>
        </div>
    </label>
    <input type="hidden" id="input_file_{{$id}}" @isset($name) name="{{$name}}" @endisset @if($value) value="{{$value}}" @endif>
    <div class="invalid-feedback"></div>
    <div class="progress progress_file_{{$id}}" style="display: none;">
        <div class="progress-bar bg-primary" role="progressbar" style="width: 0%;"
                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
    </div>
</div>
@elseif($type=="checkbox")
<div class="mb-3">
    <div class="">
        <div class="form-check">
            <input  type="checkbox"
                    @class(['form-check-input'])
                    @isset($name) name="{{$name}}" @endisset
                    id="{{$id}}"
                    {{ $value ? 'checked' : '' }}>

            <label class="form-check-label" for="{{$id}}">
                {{ $label }}
            </label>
        </div>
    </div>
</div>
@else
<div class="mb-3">
    <label for="{{$id}}" class="form-label">{{$label}}</label>
    <input
        type="{{$type == "number" ? "text" : $type}}"
        @class(['form-control', 'number-input' => $type == "number", 'is-invalid' => $errors->has($name ?? '')])
        @isset($name) name="{{$name}}" @endisset
        id="{{$id}}"
        placeholder="{{$placeholder ?? $label}}"
        @if($value) value="{{$value}}" @endif
        {{$inputAttributes}}
        @isset($help)  aria-describedby="help{{$id}}" @endisset
    />
    @isset($help)
        <small id="help{{$id}}" class="form-text text-muted">{{$help}}</small>
    @endisset
    <div class="invalid-feedback">
        @error($name ?? '')
            {{$message}}
        @enderror
    </div>
</div>
@endif
