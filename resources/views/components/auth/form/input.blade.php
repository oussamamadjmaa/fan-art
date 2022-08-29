@props(['type'=>'text'])
@php
$icons = [
    'name'                  => 'fa fa-user',
    'password'              => 'fa fa-lock',
    'current_password'          => 'fa fa-lock',
    'new_password'          => 'fa fa-lock',
    'new_password_confirmation' => 'fa fa-lock',
    'password_confirmation' => 'fa fa-lock',
    'email'                 => 'fa fa-envelope',
    'nationality'           => 'fa fa-globe',
    'country'               => 'bi bi-geo-alt-fill',
    'gender'                => 'fa fa-venus-mars',
    'website'               => 'fas fa-external-link-alt',
    'phone'                 => 'fa fa-phone',
    'username'              => 'fa fa-user',
    'facebook'              => 'fab fa-facebook',
    'instagram'             => 'fab fa-instagram',
    'twitter'               => 'fab fa-twitter',
    'linkedin'              => 'fab fa-linkedin',
    'bio'                   => 'fas fa-address-card'
];
$icon = $icons[$attributes->get('name')] ?? 'fas fa-question-circle';
@endphp

@if($type == "textarea")
<div class="mb-3">
    <div @class(['input-container', 'is-invalid' => $errors->has($attributes->get('name'))])>
        <label for="{{ $attributes->get('id') }}" class="form-label"><i class="{{ $icon }}"></i></label>
        <textarea
            {{ $attributes->class(['form-control'])->merge([
            ]) }} >{{ $attributes->get('value') }}</textarea>
    </div>
    @error($attributes->get('name'))
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
@elseif ($type == 'email')
    <div class="mb-3">
        <div @class(['input-container', 'is-invalid' => $errors->has($attributes->get('name'))])>
            <label for="{{ $attributes->get('id') }}" class="form-label"><i class="{{ $icon }}"></i></label>
            <input
                {{ $attributes->class(['form-control'])->merge([
                    'type' => 'email',
                    'name' => 'email',
                    'id' => 'email',
                    'autocomplete' => 'email',
                ]) }} />
        </div>
        <span class="invalid-feedback" role="alert">
            @error($attributes->get('name'))
            <strong>{{ $message }}</strong>
            @enderror
        </span>
    </div>
@elseif($type == 'select')
    <div class="mb-3">
        <div @class(['input-container', 'is-invalid' => $errors->has($attributes->get('name'))])>
            <label for="{{ $attributes->get('id') }}" class="form-label"><i class="{{$icon}}"></i></label>
            <select
                {{ $attributes->class(['form-control'])->merge([
                    'type' => $type,
                ]) }}>
                {{ $slot }}
            </select>
        </div>
        <span class="invalid-feedback" role="alert">
            @error($attributes->get('name'))
            <strong>{{ $message }}</strong>
            @enderror
        </span>
    </div>
@else
    <div class="mb-3">
        <div @class(['input-container', 'is-invalid' => $errors->has($attributes->get('name'))])>
            <label for="{{ $attributes->get('id') }}" class="form-label" @class(['is-invalid' => $errors->has($attributes->get('name'))])><i class="{{ $icon }}"></i></label>
            <input
                {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($attributes->get('name'))])->merge([
                    'type' => $type,
                ]) }}>
            @if ($type == 'password')
                <span class="show-password"><i class="fa"></i></span>
            @endif
        </div>

        <span class="invalid-feedback" role="alert">
            @error($attributes->get('name'))
            <strong>{{ $message }}</strong>
            @enderror
        </span>
    </div>
@endif
